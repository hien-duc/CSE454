<?php
require_once 'functions.php';
requireAdmin();

$id = $_GET['id'] ?? null;

if (!$id) {
    displayAlert('Invalid user ID', 'danger');
    header('Location: users.php');
    exit;
}

// Check if user exists and is not the last admin
$stmt = $conn->prepare("SELECT type FROM users WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

if (!$user) {
    displayAlert('User not found', 'danger');
    header('Location: users.php');
    exit;
}

// Prevent deleting own account
if ($id == $_SESSION['user_id']) {
    displayAlert('You cannot delete your own account', 'danger');
    header('Location: users.php');
    exit;
}

if ($user['type'] === 'admin') {
    // Count remaining admins
    $result = $conn->query("SELECT COUNT(*) as admin_count FROM users WHERE type = 'admin'");
    $admin_count = $result->fetch_assoc()['admin_count'];

    if ($admin_count <= 1) {
        displayAlert('Cannot delete the last admin user', 'danger');
        header('Location: users.php');
        exit;
    }
}

// Delete the user
$stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    displayAlert('User deleted successfully', 'success');
} else {
    displayAlert('Error deleting user: ' . $conn->error, 'danger');
}

header('Location: users.php');
exit;
