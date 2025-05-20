<?php
session_start();

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// DB config
$db_host = 'localhost';
$db_port = '3307';
$db_name = 'ecwa_forms';
$db_user = 'root';
$db_pass = '';

// Response structure
$response = ['success' => false, 'message' => ''];

// Ensure form_type is set
if (!isset($_POST['form_type'])) {
    echo json_encode(['success' => false, 'message' => 'Form type is required']);
    exit;
}

$form_type = trim($_POST['form_type']);

try {
    // Connect to DB
    $pdo = new PDO("mysql:host=$db_host;port=$db_port;dbname=$db_name", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    switch ($form_type) {
        case 'register':
            // Validate fields
            $required = ['email', 'password'];
            foreach ($required as $field) {
                if (empty($_POST[$field])) {
                    throw new Exception("All fields are required for registration");
                }
            }

            $email = trim($_POST['email']);
            $password = $_POST['password'];

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new Exception("Invalid email address format");
            }

            // Check if user exists
            $stmt = $pdo->prepare("SELECT id FROM users WHERE email = :email");
            $stmt->execute([':email' => $email]);

            if ($stmt->fetch()) {
                throw new Exception("Email already in use");
            }

            // Insert user
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $stmt = $pdo->prepare("INSERT INTO users (email, password) VALUES (:email, :password)");
            $stmt->execute([
                ':email' => $email,
                ':password' => $hashedPassword
            ]);

            $response = [
                'success' => true,
                'message' => 'Registration successful!'
            ];
            break;

        case 'login':
            if (empty($_POST['email']) || empty($_POST['password'])) {
                throw new Exception("Email and password are required");
            }

            $email = trim($_POST['email']);
            $password = $_POST['password'];

            $stmt = $pdo->prepare("SELECT id, password FROM users WHERE email = :email");
            $stmt->execute([':email' => $email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$user || !password_verify($password, $user['password'])) {
                throw new Exception("Invalid email or password");
            }

            $_SESSION['user_id'] = $user['id'];

            $response = [
                'success' => true,
                'message' => 'Login successful!',
                'redirect' => 'dashboard.php'
            ];
            break;

        case 'contact':
            $required = ['contact_name', 'contact_email', 'contact_message'];
            foreach ($required as $field) {
                if (empty($_POST[$field])) {
                    throw new Exception("Please fill all required fields");
                }
            }

            $name = trim($_POST['contact_name']);
            $email = trim($_POST['contact_email']);
            $phone = trim($_POST['contact_phone'] ?? '');
            $subject = trim($_POST['contact_subject'] ?? '');
            $message = trim($_POST['contact_message']);

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new Exception("Invalid email address format");
            }

            $stmt = $pdo->prepare("INSERT INTO contact_submissions 
                (contact_name, contact_email, contact_phone, contact_subject, contact_message, submission_date) 
                VALUES (:name, :email, :phone, :subject, :message, NOW())");

            $stmt->execute([
                ':name' => $name,
                ':email' => $email,
                ':phone' => $phone,
                ':subject' => $subject,
                ':message' => $message
            ]);

            $response = [
                'success' => true,
                'message' => 'Thank you for your message! We will get back to you soon.'
            ];
            break;

        default:
            throw new Exception("Invalid form submission type");
    }

} catch (PDOException $e) {
    $response['message'] = "Database error: " . $e->getMessage();
} catch (Exception $e) {
    $response['message'] = $e->getMessage();
}

// Return response
header('Content-Type: application/json');
echo json_encode($response);
exit;
