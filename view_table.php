<?php
// Database connection settings
$host = 'localhost';
$user = 'root';
$password = '';
$database = "ecwa_forms";

// Establish connection
$conn = new mysqli($host, $user, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get table name from URL parameter
$table = isset($_GET['table']) ? $_GET['table'] : '';

if (empty($table)) {
    die("No table specified.");
}

// Check if the table exists in the database
$checkTable = $conn->query("SHOW TABLES LIKE '$table'");
if ($checkTable->num_rows === 0) {
    die("Table '$table' does not exist in the database.");
}

// Query data from the specified table
$sql = "SELECT * FROM `$table`";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>

<head>
    <title>View Table - <?php echo htmlspecialchars($table); ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f9f9f9;
            padding: 30px;
        }

        h1 {
            color: #333;
            text-align: center;
        }

        table {
            margin: 0 auto;
            border-collapse: collapse;
            width: 90%;
            max-width: 1000px;
            background: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        th,
        td {
            padding: 12px 15px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #2c3e50;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .login-link {
            text-align: center;
            margin-top: 20px;
        }

        .login-link a {
            color: #007bff;
            text-decoration: none;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        .download-link {
            color: green;
            text-decoration: none;
            font-weight: bold;
        }

        .download-link:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

    <h1>Records from '<?php echo htmlspecialchars($table); ?>'</h1>

    <?php
    if ($result && $result->num_rows > 0) {
        echo "<table>";
        echo "<tr>";
        // Output column headers
        while ($fieldInfo = $result->fetch_field()) {
            echo "<th>" . htmlspecialchars($fieldInfo->name) . "</th>";
        }
        echo "<th>Receipt Action</th>"; // Extra column for download/view link
        echo "</tr>";

        // Output table rows
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            foreach ($row as $key => $cell) {
                echo "<td>" . htmlspecialchars($cell) . "</td>";
            }

            // Check for a receipt file path
            if (isset($row['receipt_path']) && !empty($row['receipt_path'])) {
                $receipt = htmlspecialchars($row['receipt_path']);
                $file = urlencode(basename($receipt));
                echo "<td><a class='download-link' href='download.php?file={$file}'>Download PDF</a></td>";
            } else {
                echo "<td>N/A</td>";
            }

            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "<p style='text-align:center; color:red;'>No records found in table '$table'.</p>";
    }

    $conn->close();
    ?>

    <p class="login-link"><a href="dashboard.php">← Return to Dashboard</a></p>

</body>

</html>