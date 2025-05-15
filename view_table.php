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

// Get table name from URL parameter and sanitize it
$table = isset($_GET['table']) ? preg_replace('/[^a-zA-Z0-9_]/', '', $_GET['table']) : '';

if (empty($table)) {
    die("No table specified.");
}

// Check if the table exists in the database
$checkTable = $conn->query("SHOW TABLES LIKE '$table'");
if ($checkTable->num_rows === 0) {
    die("Table '$table' does not exist in the database.");
}

// Get column names except 'password'
$columns = [];
$colResult = $conn->query("SHOW COLUMNS FROM `$table`");
while ($col = $colResult->fetch_assoc()) {
    if ($col['Field'] !== 'password') {
        $columns[] = "`" . $conn->real_escape_string($col['Field']) . "`";
    }
}

if (empty($columns)) {
    die("No displayable columns found.");
}

$columnList = implode(', ', $columns);
$sql = "SELECT $columnList FROM `$table`";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
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

        .download-summary-button {
            display: inline-block;
            background: #27ae60;
            color: #fff;
            padding: 10px 20px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: bold;
            margin: 30px auto 0;
            text-align: center;
        }

        .download-summary-button:hover {
            background: #219150;
        }

        .button-container {
            text-align: center;
        }
    </style>
</head>

<body>

    <h1>Records from '<?php echo htmlspecialchars($table); ?>'</h1>

    <?php if ($result && $result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <?php
                    foreach ($columns as $colName) {
                        // Remove backticks before display
                        $cleanName = str_replace('`', '', $colName);
                        echo "<th>" . htmlspecialchars($cleanName) . "</th>";
                    }
                    ?>
                    <th>Receipt Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <?php foreach ($row as $key => $value): ?>
                            <td><?php echo htmlspecialchars($value); ?></td>
                        <?php endforeach; ?>

                        <td>
                            <?php if (!empty($row['receipt'])): ?>
                                <?php $file = urlencode(basename($row['receipt'])); ?>
                                <a class="download-link" href="download.php?file=<?php echo $file; ?>">Download PDF</a>
                            <?php else: ?>
                                N/A
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p style="text-align:center; color:red;">No records found in table '<?php echo htmlspecialchars($table); ?>'.</p>
    <?php endif; ?>

    <p class="login-link"><a href="dashboard.php">← Return to Dashboard</a></p>

    <div class="button-container">
        <a href="download_summary.php?table=<?php echo urlencode($table); ?>" class="download-summary-button">
            Download Full Summary (CSV)
        </a>
    </div>

    <?php $conn->close(); ?>

</body>

</html>