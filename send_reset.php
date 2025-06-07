<?php
// Initialize session and error reporting
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// ====================
// DEPENDENCIES LOADING
// ====================
require __DIR__ . '/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Egulias\EmailValidator\EmailValidator;
use Egulias\EmailValidator\Validation\RFCValidation;

// ====================
// CONFIGURATION
// ====================
// Load environment variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Database configuration
$dbConfig = [
    'host' => 'localhost',
    'user' => 'root',
    'password' => '',
    'database' => 'ecwa_forms'
];

// ====================
// DATABASE CONNECTION
// ====================
$conn = mysqli_connect(
    $dbConfig['host'],
    $dbConfig['user'],
    $dbConfig['password'],
    $dbConfig['database']
);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// ====================
// MAIN REQUEST HANDLER
// ====================
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    handlePasswordResetRequest($conn);
}

// ====================
// FUNCTIONS
// ====================

/**
 * Handles the password reset request
 */
function handlePasswordResetRequest($conn)
{
    $email = trim($_POST['email']);

    // Validate input
    if (!validateEmail($email)) {
        setSessionError("Invalid email format.");
        redirectToForgotPassword();
    }

    // Check email existence
    if (!emailExists($conn, $email)) {
        setSessionError("No account found with that email address.");
        redirectToForgotPassword();
    }

    // Generate and store reset token
    $token = generateResetToken($conn, $email);
    if (!$token) {
        setSessionError("Failed to process your request. Please try again.");
        redirectToForgotPassword();
    }

    // Send reset email
    if (!sendResetEmail($email, $token)) {
        setSessionError("Failed to send reset email. Please try again later.");
        redirectToForgotPassword();
    }

    // Success
    setSessionMessage("A password reset link has been sent to your email. The link will expire in 10 minutes.");
    redirectToForgotPassword();
}

/**
 * Validates email format
 */
function validateEmail($email)
{
    $validator = new EmailValidator();
    return $validator->isValid($email, new RFCValidation());
}

/**
 * Checks if email exists in database
 */
function emailExists($conn, $email)
{
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

    return $stmt->num_rows > 0;
}

/**
 * Generates and stores reset token
 */
function generateResetToken($conn, $email)
{
    $token = bin2hex(random_bytes(50));
    $expiry = date("Y-m-d H:i:s", time() + 600); // 10 minutes expiry

    $table = getTableForEmail($conn, $email);
    if (empty($table)) {
        return false;
    }

    return updateResetToken($conn, $table, $email, $token, $expiry) ? $token : false;
}

/**
 * Determines which table contains the email
 */
function getTableForEmail($conn, $email)
{
    $tables = ['users', 'admins'];

    foreach ($tables as $table) {
        $stmt = $conn->prepare("SELECT id FROM $table WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            return $table;
        }
    }

    return '';
}

/**
 * Updates reset token in database
 */
function updateResetToken($conn, $table, $email, $token, $expiry)
{
    $updateSQL = "UPDATE $table SET reset_token = ?, reset_token_expiry = ? WHERE email = ?";
    $updateStmt = $conn->prepare($updateSQL);
    if (!$updateStmt) {
        die("Prepare failed: " . $conn->error);
    }
    $updateStmt->bind_param("sss", $token, $expiry, $email);
    return $updateStmt->execute();
}

/**
 * Sends password reset email
 */
function sendResetEmail($email, $token)
{
    $mail = new PHPMailer(true);

    try {
        // SMTP Configuration
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = $_ENV['EMAIL_USERNAME'];
        $mail->Password = $_ENV['EMAIL_PASSWORD'];
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Email content
        $mail->setFrom($_ENV['EMAIL_USERNAME'], 'ECWA Education Levy Management System');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = "Password Reset Request";

        $resetLink = "http://localhost/Ecwawork/reset_form.php?token=" . urlencode($token);
        $mail->Body = buildEmailBody($resetLink);

        return $mail->send();
    } catch (Exception $e) {
        error_log("Mailer Error: " . $e->getMessage());
        return false;
    }
}

/**
 * Builds the email HTML body
 */
function buildEmailBody($resetLink)
{
    return "
        <p>Click the link below to reset your password:</p>
        <p><a href='$resetLink' style='padding: 10px; background-color: blue; color: white; text-decoration: none;'>Reset Password</a></p>
        <p>If you did not request this, please ignore this email.</p>
        <p>This link will expire in 10 minutes for your security.</p>
    ";
}

/**
 * Sets session error message
 */
function setSessionError($message)
{
    $_SESSION['error'] = $message;
}

/**
 * Sets session success message
 */
function setSessionMessage($message)
{
    $_SESSION['message'] = $message;
}

/**
 * Redirects to forgot password page
 */
function redirectToForgotPassword()
{
    header("Location: forgot_password.php");
    exit();
}