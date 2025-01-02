<?php
require_once 'functions.php';
requireLogin();

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if (!$id) {
    header('Location: products.php');
    exit;
}

// Get product details first
$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$product = $stmt->get_result()->fetch_assoc();

if (!$product) {
    displayAlert('Product not found', 'danger');
    header('Location: products.php');
    exit;
}

// Start transaction
$conn->begin_transaction();

try {
    // Delete main product image
    if ($product['image_url'] && file_exists($product['image_url'])) {
        unlink($product['image_url']);
    }

    // Get and delete gallery images
    $stmt = $conn->prepare("SELECT image_url FROM product_images WHERE product_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $gallery_images = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    foreach ($gallery_images as $image) {
        if (file_exists($image['image_url'])) {
            unlink($image['image_url']);
        }
    }

    // Delete gallery images from database
    $stmt = $conn->prepare("DELETE FROM product_images WHERE product_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    // Delete product
    $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    // Commit transaction
    $conn->commit();

    displayAlert('Product deleted successfully', 'success');
} catch (Exception $e) {
    // Rollback transaction on error
    $conn->rollback();
    displayAlert('Error deleting product: ' . $e->getMessage(), 'danger');
}

header('Location: products.php');
exit;
?>