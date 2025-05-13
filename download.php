<?php
if (!isset($_GET['file'])) {
    die(" No file specified.");
}

$filename = basename($_GET['file']);
$filepath = __DIR__ . "/uploads/" . $filename;

if (!file_exists($filepath)) {
    die("File does not exist.");
}

header('Content-Description: File Transfer');
header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Length: ' . filesize($filepath));

readfile($filepath);
exit;
