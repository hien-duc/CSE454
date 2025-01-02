<?php
require_once 'functions.php';
requireLogin();

$image_id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$product_id = isset($_GET['product_id']) ? (int) $_GET['product_id'] : 0;

if (!$image_id || !$product_id) {
    displayAlert('Invalid request', 'danger');
    header('Location: products.php');
    exit;
}

// Get image details
$stmt = $conn->prepare("SELECT pi.*, p.user_id FROM product_images pi 
                       JOIN products p ON pi.product_id = p.id 
                       WHERE pi.id = ? AND pi.product_id = ?");
$stmt->bind_param("ii", $image_id, $product_id);
$stmt->execute();
$image = $stmt->get_result()->fetch_assoc();

if (!$image) {
    displayAlert('Image not found', 'danger');
    header('Location: manage_gallery.php?id=' . $product_id);
    exit;
}

// Check permissions
$user = getCurrentUser();
if ($user['type'] !== 'admin' && $image['user_id'] !== $user['id']) {
    displayAlert('You do not have permission to delete this image', 'danger');
    header('Location: manage_gallery.php?id=' . $product_id);
    exit;
}

// Delete the physical file
if (file_exists($image['image_url'])) {
    unlink($image['image_url']);
}

// Delete from database
$stmt = $conn->prepare("DELETE FROM product_images WHERE id = ?");
$stmt->bind_param("i", $image_id);

if ($stmt->execute()) {
    displayAlert('Image deleted successfully', 'success');
} else {
    displayAlert('Error deleting image', 'danger');
}

header('Location: manage_gallery.php?id=' . $product_id);
exit;
?>