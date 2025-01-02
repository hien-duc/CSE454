<?php

session_start();


$serverName = "localhost";
$userName = "root";
$password = "";
$dbName = "product_management";


$conn = new mysqli($serverName, $userName, $password, $dbName);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


function requireLogin()
{
    if (!isset($_SESSION['user_id'])) {
        header('Location: login.php');
        exit;
    }
}


function requireAdmin()
{
    if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'admin') {
        header('Location: index.php');
        exit;
    }
}

/**
 * @param int $userId
 * @return bool
 */
function isAuthorized($userId)
{
    return isset($_SESSION['user_id']) && ($_SESSION['user_type'] === 'admin' || $_SESSION['user_id'] === $userId);
}