<?php
require_once 'functions.php';
requireAdmin();

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: users.php');
    exit;
}

// Check if user exists and is not the last admin
$stmt = $conn->prepare("SELECT type FROM users WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

if ($user && $user['type'] === 'admin') {
    // Count remaining admins
    $result = $conn->query("SELECT COUNT(*) as admin_count FROM users WHERE type = 'admin'");
    $admin_count = $result->fetch_assoc()['admin_count'];
    
    if ($admin_count <= 1) {
        $_SESSION['error'] = "Cannot delete the last admin user.";
        header('Location: users.php');
        exit;
    }
}

// Delete the user
$stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header('Location: users.php');
} else {
    $_SESSION['error'] = "Error deleting user: " . $conn->error;
    header('Location: users.php');
}
exit;
