<?php
$serverName = "localhost";
$userName = "root";
$password = "";
$dbName = "lab6";
$port = 3306;

$conn = mysqli_connect($serverName, $userName, $password, $dbName);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Constants for file upload
define('UPLOAD_DIR', __DIR__ . '/uploads/');
define('MAX_FILE_SIZE', 5 * 1024 * 1024); // 5MB
define('ALLOWED_EXTENSIONS', ['jpg', 'jpeg', 'png', 'gif']);

// Create uploads directory if it doesn't exist
if (!file_exists(UPLOAD_DIR)) {
    mkdir(UPLOAD_DIR, 0777, true);
}

// Create subdirectories for different types of images
$dirs = ['products', 'gallery'];
foreach ($dirs as $dir) {
    $path = UPLOAD_DIR . $dir;
    if (!file_exists($path)) {
        mkdir($path, 0777, true);
    }
}
?>