<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// =========================
// DATABASE CONFIGURATION
// =========================
$host = "127.0.0.1";
$port = 3307;
$username = "root";
$password = "";
$database = "ecwa_forms";

// Create MySQL connection
$conn = new mysqli($host, $username, $password, $database, $port);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// =========================
// HANDLE PASSWORD RESET FORM
// =========================
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['token'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    // Validate passwords
    if (empty($password) || empty($confirm_password)) {
        $_SESSION['error'] = "Both password fields are required.";
        header("Location: reset_password.php?token=" . urlencode($token));
        exit();
    }

    if ($password !== $confirm_password) {
        $_SESSION['error'] = "Passwords do not match.";
        header("Location: reset_password.php?token=" . urlencode($token));
        exit();
    }

    // Check if token is valid and identify user type
    $sql = "
        SELECT id, 'users' AS user_type 
        FROM users 
        WHERE reset_token = ? AND reset_token_expiry > NOW()
        UNION
        SELECT id, 'admins' AS user_type 
        FROM admins 
        WHERE reset_token = ? AND reset_token_expiry > NOW()
        LIMIT 1
    ";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("ss", $token, $token);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($user_id, $user_type);
        $stmt->fetch();
        $stmt->close();

        // Hash the new password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Update query based on user type
        if ($user_type === 'users') {
            $update_sql = "UPDATE users SET password = ?, reset_token = NULL, reset_token_expiry = NULL WHERE id = ?";
        } else { // admins
            $update_sql = "UPDATE admins SET password_hash = ?, reset_token = NULL, reset_token_expiry = NULL WHERE id = ?";
        }

        $update_stmt = $conn->prepare($update_sql);
        if (!$update_stmt) {
            die("Prepare failed: " . $conn->error);
        }

        $update_stmt->bind_param("si", $hashed_password, $user_id);

        if ($update_stmt->execute()) {
            $_SESSION['message'] = "Your password has been reset successfully.";

            // Redirect based on user type
            if ($user_type === 'users') {
                header("Location: index.php");
            } else {
                header("Location: login.php");
            }
            exit();
        } else {
            $_SESSION['error'] = "Error updating password.";
            header("Location: reset_password.php?token=" . urlencode($token));
            exit();
        }
    } else {
        $_SESSION['error'] = "Invalid or expired token.";
        header("Location: index.php");
        exit();
    }
}
?>