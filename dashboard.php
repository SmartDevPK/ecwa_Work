<?php
// Start the session
session_start();

// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$host = "127.0.0.1";
$port = 3307;
$username = "root";
$password = "";
$database = "ecwa_forms";

// Connect to the database
$conn = new mysqli($host, $username, $password, $database, $port);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

// Get table names
$sql = "SHOW TABLES";
$result = $conn->query($sql);

$tables = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $tables[] = $row['Tables_in_' . $database];
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        :root {
            --primary-color: #007bff;
            --background-color: #f8f9fa;
            --card-bg: #fff;
            --text-color: #333;
            --hover-color: #0056b3;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--background-color);
            color: var(--text-color);
        }

        header {
            background-color: var(--primary-color);
            color: #fff;
            padding: 1rem 2rem;
            text-align: center;
        }

        main {
            max-width: 800px;
            margin: 30px auto;
            background: var(--card-bg);
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        }

        h2 {
            margin-bottom: 10px;
        }

        p {
            margin-bottom: 20px;
        }

        ul {
            list-style: none;
            padding: 0;
        }

        li {
            margin-bottom: 12px;
        }

        a.table-link {
            display: block;
            background-color: #e9ecef;
            padding: 12px 16px;
            border-radius: 6px;
            text-decoration: none;
            color: var(--text-color);
            transition: background-color 0.3s ease;
        }

        a.table-link:hover {
            background-color: var(--primary-color);
            color: #fff;
        }

        .logout-link {
            display: inline-block;
            margin-top: 30px;
            padding: 10px 20px;
            background-color: crimson;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            text-align: center;
        }

        .logout-link:hover {
            background-color: darkred;
        }

        @media (max-width: 600px) {
            main {
                padding: 20px;
            }

            a.table-link {
                font-size: 1em;
            }
        }
    </style>
</head>

<body>

    <header>
        <h1>Welcome to Admin Dashboard</h1>
    </header>

    <main>
        <h2>Available Tables</h2>
        <p>Select a table to view its data:</p>
        <ul>
            <?php foreach ($tables as $tableName): ?>
                <li><a class="table-link"
                        href="view_table.php?table=<?= htmlspecialchars($tableName) ?>"><?= htmlspecialchars($tableName) ?></a>
                </li>
            <?php endforeach; ?>
        </ul>

        <a href="logout.php" class="logout-link">Logout</a>
    </main>

</body>

</html>