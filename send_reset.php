<?php
session_start();

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Autoload dependencies
require __DIR__ . '/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Egulias\EmailValidator\EmailValidator;
use Egulias\EmailValidator\Validation\RFCValidation;

// Load environment variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Database connection
$conn = mysqli_connect('localhost', 'root', '', 'ecwa_forms');
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Handle POST form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);

    // Validate email format
    $validator = new EmailValidator();
    if (!$validator->isValid($email, new RFCValidation())) {
        $_SESSION['error'] = "Invalid email format.";
        header("Location: forgot_password.php");
        exit();
    }

    // Check if email exists in either users or admins tables
    $sql = "SELECT id FROM users WHERE email = ? 
            UNION 
            SELECT id FROM admins WHERE email = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("ss", $email, $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 0) {
        $_SESSION['error'] = "No account found with that email address.";
        header("Location: forgot_password.php");
        exit();
    }

    // Generate secure token and expiry time (1 hour)
    $token = bin2hex(random_bytes(50));
    $expiry = date("Y-m-d H:i:s", time() + 3600);

    // Determine which table contains the email
    $tableToUpdate = '';

    $stmtUser = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmtUser->bind_param("s", $email);
    $stmtUser->execute();
    $stmtUser->store_result();

    if ($stmtUser->num_rows > 0) {
        $tableToUpdate = 'users';
    } else {
        $stmtAdmin = $conn->prepare("SELECT id FROM admins WHERE email = ?");
        $stmtAdmin->bind_param("s", $email);
        $stmtAdmin->execute();
        $stmtAdmin->store_result();

        if ($stmtAdmin->num_rows > 0) {
            $tableToUpdate = 'admins';
        }
    }

    if ($tableToUpdate === '') {
        $_SESSION['error'] = "No account found with that email address.";
        header("Location: forgot_password.php");
        exit();
    }

    // Update reset token and expiry in the appropriate table
    $updateSQL = "UPDATE $tableToUpdate SET reset_token = ?, reset_token_expiry = ? WHERE email = ?";
    $updateStmt = $conn->prepare($updateSQL);
    if (!$updateStmt) {
        die("Prepare failed: " . $conn->error);
    }
    $updateStmt->bind_param("sss", $token, $expiry, $email);
    $updateStmt->execute();

    // Send password reset email
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = $_ENV['EMAIL_USERNAME'];
        $mail->Password = $_ENV['EMAIL_PASSWORD'];
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom($_ENV['EMAIL_USERNAME'], 'ECWA Education Levy Management System');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = "Password Reset Request";

        $resetLink = "http://localhost/Ecwawork/reset_form.php?token=$token";
        $mail->Body = "
            <p>Click the link below to reset your password:</p>
            <p><a href='$resetLink' style='padding: 10px; background-color: blue; color: white; text-decoration: none;'>Reset Password</a></p>
            <p>If you did not request this, please ignore this email.</p>
        ";

        $mail->send();
        $_SESSION['message'] = "A password reset link has been sent to your email.";
    } catch (Exception $e) {
        $_SESSION['error'] = "Mailer Error: " . $mail->ErrorInfo;
    }

    // Redirect back to forgot_password.php
    header("Location: forgot_password.php");
    exit();
}
?>