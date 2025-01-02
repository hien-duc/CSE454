<?php
session_start();
require_once 'functions.php';

requireLogin();
requireAdmin();

$serverName = "localhost";
$userName = "root";
$password = "";
$dbName = "product_management";

$conn = new mysqli($serverName, $userName, $password, $dbName);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $userId = intval($_GET['id']);

    if ($userId == $_SESSION['user_id']) {
        header("Location: user-management.php?error=cannot_delete_self");
        exit;
    }

    $sql = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        header("Location: user-management.php?success=user_deleted");
    } else {
        header("Location: user-management.php?error=user_not_found");
    }
    exit;
} else {
    header("Location: user-management.php?error=invalid_request");
    exit;
}

$conn->close();
?>