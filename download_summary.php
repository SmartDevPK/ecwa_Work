<?php
// Database connection settings
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);



$host = 'localhost';
$user = 'root';
$password = '';
$database = 'ecwa_forms';

// Establish connection
$conn = new mysqli($host, $user, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get table name from URL parameter, sanitize input
$table = isset($_GET['table']) ? preg_replace('/[^a-zA-Z0-9_]/', '', $_GET['table']) : '';

if (empty($table)) {
    die("No table specified.");
}

// Check if the table exists
$checkTable = $conn->query("SHOW TABLES LIKE '$table'");
if ($checkTable->num_rows === 0) {
    die("Table '$table' does not exist.");
}

// Fetch all records
$sql = "SELECT * FROM `$table`";
$result = $conn->query($sql);
if (!$result) {
    die("Query error: " . $conn->error);
}

// Set headers to force download of CSV file
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=' . $table . '_summary_' . date('Y-m-d') . '.csv');

// Open output stream for writing CSV
$output = fopen('php://output', 'w');

// Fetch and write column headers
$fields = $result->fetch_fields();
$headers = [];
foreach ($fields as $field) {
    $headers[] = $field->name;
}
fputcsv($output, $headers);

// Write all rows to CSV
while ($row = $result->fetch_assoc()) {
    fputcsv($output, $row);
}

// Close connection and output stream
$conn->close();
fclose($output);
exit();
