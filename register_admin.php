<?php
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database connection
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

$error = '';
$success = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    // Validate inputs
    if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        $error = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } elseif ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    } else {
        // Check password strength
        function strongPassword($password): array
        {
            if (strlen($password) < 12)
                return [false, "Password must be at least 12 characters."];
            if (!preg_match('/[A-Z]/', $password))
                return [false, "Include at least one uppercase letter."];
            if (!preg_match('/[a-z]/', $password))
                return [false, "Include at least one lowercase letter."];
            if (!preg_match('/[0-9]/', $password))
                return [false, "Include at least one digit."];
            if (!preg_match('/[^a-zA-Z0-9]/', $password))
                return [false, "Include at least one special character."];
            return [true, null];
        }

        [$valid, $validationError] = strongPassword($password);
        if (!$valid) {
            $error = $validationError;
        } else {
            // Check if admin already exists
            $stmt = $conn->prepare("SELECT id FROM admins WHERE email = ? OR username = ?");
            $stmt->bind_param("ss", $email, $username);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $error = "Username or email already exists.";
            } else {
                // Hash password securely
                $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

                // Insert admin into DB
                $stmt = $conn->prepare("INSERT INTO admins (username, email, password_hash, created_at) VALUES (?, ?, ?, NOW())");
                $stmt->bind_param("sss", $username, $email, $hashedPassword);
                if ($stmt->execute()) {
                    $success = "Admin account created successfully!";
                    header("Location: login.php");
                    exit;
                } else {
                    $error = "Error creating admin: " . $conn->error;
                }
            }
        }
    }
}

?>



<!DOCTYPE html>
<html>

<head>
    <title>Admin Registration</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        h2 {
            text-align: center;
            margin-top: 40px;
            color: #333;
        }

        .registration-container {
            background-color: #fff;
            max-width: 400px;
            margin: 30px auto;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        input,
        button {
            width: 100%;
            padding: 12px;
            margin-top: 10px;
            font-size: 1em;
            border-radius: 4px;
            border: 1px solid #ccc;
        }

        button {
            background-color: #007bff;
            color: white;
            border: none;
        }

        button:hover {
            background-color: #0056b3;
        }

        .message {
            text-align: center;
            margin-top: 10px;
            color: red;
        }

        .message.success {
            color: green;
        }

        .login-link {
            text-align: center;
            margin-top: 10px;
        }

        .login-link a {
            color: #007bff;
            text-decoration: none;
        }

        .login-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <h2>Create Admin Account</h2>
    <div class="registration-container">
        <?php if (!empty($error)): ?>
            <p class="message"><?php echo htmlspecialchars($error); ?></p>
        <?php elseif (!empty($success)): ?>
            <p class="message success"><?php echo htmlspecialchars($success); ?></p>
        <?php endif; ?>
        <form method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="password" name="confirm_password" placeholder="Confirm Password" required>
            <button type="submit">Register</button>
        </form>
        <p class="login-link"><a href="login.php">If you have an account, login</a></p>
    </div>
</body>

</html>