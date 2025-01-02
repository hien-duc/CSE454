<?php
session_start();

$serverName = "localhost";
$userName = "root";
$password = "";
$dbName = "product";

$conn = mysqli_connect($serverName, $userName, $password, $dbName);
if (!$conn) {
    die("Connection failed.");
}

function hashPassword($password) {
    return password_hash($password, PASSWORD_DEFAULT);
}

function verifyPassword($password, $hashedPassword) {
    return password_verify($password, $hashedPassword);
}

function requireLogin() {
    if (!isset($_SESSION['user_id'])) {
        header('Location: login.php');
        exit;
    }
}

function requireAdmin() {
    if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'admin') {
        header('Location: index.php');
        exit;
    }
}

function isAuthorized() {
    return isset($_SESSION['user_id']) && 
           ($_SESSION['user_type'] === 'admin' || 
            $_SESSION['user_type'] === 'author' || 
            $_SESSION['user_type'] === 'normal');
}
?>
