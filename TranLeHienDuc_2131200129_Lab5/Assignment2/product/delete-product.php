<?php
session_start();
require_once 'functions.php';

requireLogin();

$serverName = "localhost";
$userName = "root";
$password = "";
$dbName = "product_management";

$conn = new mysqli($serverName, $userName, $password, $dbName);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $id = intval($_GET["id"]);

    $sql = "DELETE FROM `products` WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $stmt->close();
    header("Location: index.php");
    exit;
}


$conn->close();
?>