<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$conn = mysqli_connect('localhost', 'root', '', 'ecwa_forms');
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['token'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if passwords match
    if ($password !== $confirm_password) {
        $_SESSION['error'] = "Passwords do not match.";
        header("Location: reset_password.php?token=" . urlencode($token));
        exit();
    }

    // Check if the token is valid and not expired and identify which table the user belongs to
    $sql = "
        SELECT id, 'users' AS user_type FROM users WHERE reset_token = ? AND reset_token_expiry > NOW()
        UNION
        SELECT id, 'admins' AS user_type FROM admins WHERE reset_token = ? AND reset_token_expiry > NOW()
    ";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("ss", $token, $token);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id, $user_type);
        $stmt->fetch();
        $stmt->close();

        // Hash new password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Prepare update query depending on user type (table)
        if ($user_type === 'users') {
            $update_sql = "UPDATE users SET password = ?, reset_token = NULL, reset_token_expiry = NULL WHERE id = ?";
        } else {
            $update_sql = "UPDATE admins SET password = ?, reset_token = NULL, reset_token_expiry = NULL WHERE id = ?";
        }

        $update_stmt = $conn->prepare($update_sql);
        if (!$update_stmt) {
            die("Prepare failed: " . $conn->error);
        }
        $update_stmt->bind_param("si", $hashed_password, $user_id);

        if ($update_stmt->execute()) {
            $_SESSION['message'] = "Your password has been reset successfully.";
            header("Location: login.php");
            exit();
        } else {
            $_SESSION['error'] = "Error updating password.";
            header("Location: reset_password.php?token=" . urlencode($token));
            exit();
        }
    } else {
        $_SESSION['error'] = "Invalid or expired token.";
        header("Location: login.php");
        exit();
    }
}
?>