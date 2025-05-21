<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection details
$host = "127.0.0.1";
$port = 3307;
$dbUser = "root";
$dbPass = "";
$dbName = "ecwa_forms";

// Connect to database
$conn = new mysqli($host, $dbUser, $dbPass, $dbName, $port);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        $error = "All fields are required.";
    } else {
        // Fetch user by email
        $stmt = $conn->prepare("SELECT id, password, failed_attempts, last_failed_login FROM admins WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            $error = "Invalid email or password.";
        } else {
            $user = $result->fetch_assoc();

            $now = new DateTime();
            $lastFailed = $user['last_failed_login'] ? new DateTime($user['last_failed_login']) : null;

            // Calculate minutes since last failed login
            $minutesSinceLastFail = 0;
            if ($lastFailed) {
                $interval = $now->diff($lastFailed);
                $minutesSinceLastFail = $interval->i + ($interval->h * 60) + ($interval->d * 1440);
            }

            // Lockout check
            if ($user['failed_attempts'] >= 3 && $minutesSinceLastFail < 45) {
                $remaining = 45 - $minutesSinceLastFail;
                $error = "Too many failed attempts. Please try again after {$remaining} minute(s).";
            } elseif (password_verify($password, $user['password'])) {
                // Successful login: reset attempts
                $stmt = $conn->prepare("UPDATE admins SET failed_attempts = 0, last_failed_login = NULL WHERE id = ?");
                $stmt->bind_param("i", $user['id']);
                $stmt->execute();

                $_SESSION['admin_id'] = $user['id'];
                header("Location: dashboard.php");
                exit;
            } else {
                // Failed login: increment attempts
                $failedAttempts = $user['failed_attempts'] + 1;
                $stmt = $conn->prepare("UPDATE admins SET failed_attempts = ?, last_failed_login = NOW() WHERE id = ?");
                $stmt->bind_param("ii", $failedAttempts, $user['id']);
                $stmt->execute();

                $error = "Invalid email or password.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Admin Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        h2 {
            text-align: center;
            margin-top: 50px;
            color: #333;
        }

        .login-container {
            background-color: #fff;
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .login-container input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 1em;
        }

        .login-container button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 1.1em;
            cursor: pointer;
        }

        .login-container button:hover {
            background-color: #0056b3;
        }

        .error-message {
            color: red;
            text-align: center;
            margin-top: 10px;
        }

        .login-link,
        .forgot-password {
            text-align: center;
            margin-top: 10px;
        }

        .login-link a,
        .forgot-password a {
            color: #007bff;
            text-decoration: none;
        }

        .login-link a:hover,
        .forgot-password a:hover {
            text-decoration: underline;
        }

        .login-container p {
            margin: 0;
        }
    </style>
</head>

<body>
    <h2>Admin Login</h2>

    <div class="login-container">
        <?php if (!empty($error)): ?>
            <p class="error-message"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <form method="POST" novalidate>
            <input type="email" name="email" placeholder="Email" required />
            <input type="password" name="password" placeholder="Password" required />

            <button type="submit">Login</button>

            <p class="forgot-password">
                <a href="forgot_password.php">Forgot Password?</a>
            </p>

            <p class="login-link">
                <a href="register_admin.php">New Member Sign up</a>
            </p>
        </form>
    </div>
</body>

</html>