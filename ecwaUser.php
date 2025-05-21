<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
// Database connection
$host = "127.0.0.1";
$port = 3307;
$dbUser = "root";
$dbPass = "";
$dbName = "ecwa_forms";

$conn = new mysqli($host, $dbUser, $dbPass, $dbName, $port);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $school_name = $_POST['school_name'];
    $year = $_POST['year'];
    $number_of_students = $_POST['number_of_students'];
    $amount_paid = $_POST['amount_paid'];

    $targetDir = "uploads/";
    if (!file_exists($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    $fileName = basename($_FILES["receipt"]["name"]);
    $targetFilePath = $targetDir . time() . '_' . $fileName;
    $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));
    $allowedTypes = ["jpg", "jpeg", "png", "pdf"];

    if (in_array($fileType, $allowedTypes)) {
        if (move_uploaded_file($_FILES["receipt"]["tmp_name"], $targetFilePath)) {
            $stmt = $conn->prepare("INSERT INTO school_receipt_submissions (school_name, year, number_of_students, amount_paid, receipt) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("ssids", $school_name, $year, $number_of_students, $amount_paid, $targetFilePath);

            if ($stmt->execute()) {
                $message = " Submission successful!";
            } else {
                $message = " Error saving to database.";
            }
            $stmt->close();
        } else {
            $message = " Failed to upload file.";
        }
    } else {
        $message = " Invalid file type. Allowed types: jpg, jpeg, png, pdf.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>User Dashboard</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f5f8fa;
            padding: 40px;
        }

        h2 {
            color: #2c3e50;
            text-align: center;
        }

        form {
            max-width: 500px;
            margin: 30px auto;
            background-color: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="date"],
        input[type="number"],
        select,
        input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border-radius: 8px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        button {
            margin-top: 20px;
            width: 100%;
            padding: 12px;
            background-color: #3498db;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }

        button:hover {
            background-color: #2980b9;
        }

        .msg {
            text-align: center;
            color: green;
            font-weight: bold;
        }

        .error {
            text-align: center;
            color: red;
            font-weight: bold;
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

    <h2>School Dashboard</h2>

    <?php if ($message): ?>
        <p class="<?= strpos($message, '✅') !== false ? 'msg' : 'error' ?>">
            <?= htmlspecialchars($message) ?>
        </p>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data" novalidate>
        <label>School Name:</label>
        <select name="school_name" required>
            <option value="">Select a School</option>
            <option value="Bingham University College of Medicine and Allied Health Sciences, Jos">Bingham University
                College of Medicine and Allied Health Sciences, Jos</option>
            <option value="ECWA College Of Health Technology, Kagoro">ECWA College Of Health Technology, Kagoro</option>
            <option value="ECWA College Of Nursing Sciences, Egbe, Kogi State">ECWA College Of Nursing Sciences, Egbe,
                Kogi State</option>
            <option value="ECWA International College of Education. Igbaja Kwara State">ECWA International College of
                Education. Igbaja Kwara State</option>
            <option value="ECWA International College of Education, Bayara">ECWA International College of Education,
                Bayara</option>
            <option value="ECWA International College of Education, Jos">ECWA International College of Education, Jos
            </option>
            <option value="ECWA International College of Technology, Jos">ECWA International College of Technology, Jos
            </option>
            <option value="ECWA Theological College, Billiri">ECWA Theological College, Billiri</option>
            <option value="ECWA Theological College, Donga-donga">ECWA Theological College, Donga-donga</option>
            <option value="ECWA Theological College, Gure">ECWA Theological College, Gure</option>
            <option value="ECWA Theological College, Kpada">ECWA Theological College, Kpada</option>
            <option value="ECWA Theological College, Oyi">ECWA Theological College, Oyi</option>
            <option value="ECWA Theological College, Tofa">ECWA Theological College, Tofa</option>
            <option value="ECWA Theological College, Zabolo">ECWA Theological College, Zabolo</option>
            <option value="ECWA Theological College, Zalanga">ECWA Theological College, Zalanga</option>
            <option value="ECWA Theological College, Zambuk">ECWA Theological College, Zambuk</option>
            <option value="ECWA Theological Seminary, Aba">ECWA Theological Seminary, Aba</option>
            <option value="ECWA Theological Seminary, Igbaje">ECWA Theological Seminary, Igbaje</option>
            <option value="ECWA Theological Seminary, Jos">ECWA Theological Seminary, Jos</option>
            <option value="ECWA Theological Seminary, Kagoro">ECWA Theological Seminary, Kagoro</option>
            <option value="ECWA Theological Seminary, Karu">ECWA Theological Seminary, Karu</option>
            <option value="ECWA Theological Training Institute Adunu">ECWA Theological Training Institute Adunu</option>
            <option value="ECWA Theological Training Institute Damakasuwa">ECWA Theological Training Institute
                Damakasuwa</option>
            <option value="ECWA Theological Training Institute Gelengu">ECWA Theological Training Institute Gelengu
            </option>
            <option value="ECWA Theological Training Institute Kogum">ECWA Theological Training Institute Kogum</option>
            <option value="ECWA Theological Training Institute Kwamiding">ECWA Theological Training Institute Kwamiding
            </option>
            <option value="ECWA Theological Training Institute Pisabu">ECWA Theological Training Institute Pisabu
            </option>
            <option value="ECWA Theological Training Institute Samaru-Kataf">ECWA Theological Training Institute
                Samaru-Kataf</option>
        </select>

        <br><br>

        <label>Number of Students:</label>
        <input type="number" name="number_of_students" required min="1" placeholder="Enter number of students">

        <br><br>

        <label>Amount Paid (₦):</label>
        <input type="number" name="amount_paid" required min="0" step="0.01" placeholder="Enter amount paid">

        <br><br>

        <label>Year:</label>
        <input type="date" name="year" required>

        <br><br>

        <label>Upload Receipt:</label>
        <input type="file" name="receipt" accept=".jpg,.jpeg,.png,.pdf" required>

        <br><br>

        <button type="submit">Submit</button>
        <p class="login-link"><a href="index.php">Return To Home Page</a></p>

    </form>

</body>

</html>