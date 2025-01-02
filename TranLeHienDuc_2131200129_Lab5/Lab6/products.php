<?php
require_once 'functions.php';
requireLogin();

$sql = "SELECT p.*, u.fullname as creator_name 
        FROM products p 
        LEFT JOIN users u ON p.user_id = u.id 
        ORDER BY p.date DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Product Management</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .product-image {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 5px;
        }
        .gallery-count {
            position: absolute;
            top: 5px;
            right: 5px;
            background: rgba(0,0,0,0.7);
            color: white;
            padding: 2px 8px;
            border-radius: 10px;
            font-size: 12px;
        }
        .image-container {
            position: relative;
            display: inline-block;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Product Management</h2>
            <div>
                <a href="add_product.php" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Add Product
                </a>
                <?php if ($_SESSION['user_type'] === 'admin'): ?>
                    <a href="users.php" class="btn btn-info">
                        <i class="fas fa-users"></i> Manage Users
                    </a>
                <?php endif; ?>
                <a href="logout.php" class="btn btn-secondary">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </div>

        <?php showAlert(); ?>

        <div class="table-responsive">
            <table class="table table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>#</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Brand</th>
                        <th>Quantity</th>
                        <th>Created By</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $counter = 1;
                    while ($row = mysqli_fetch_assoc($result)): 
                        // Get gallery image count
                        $stmt = $conn->prepare("SELECT COUNT(*) as count FROM product_images WHERE product_id = ?");
                        $stmt->bind_param("i", $row['id']);
                        $stmt->execute();
                        $gallery_count = $stmt->get_result()->fetch_assoc()['count'];
                    ?>
                        <tr>
                            <td><?php echo $counter++; ?></td>
                            <td>
                                <div class="image-container">
                                    <img src="<?php echo $row['image_url'] ? $row['image_url'] : 'uploads/products/default.png'; ?>" 
                                         class="product-image" 
                                         alt="<?php echo htmlspecialchars($row['product_name']); ?>">
                                    <?php if ($gallery_count > 0): ?>
                                        <span class="gallery-count">
                                            <i class="fas fa-images"></i> <?php echo $gallery_count; ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td><?php echo htmlspecialchars($row['product_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['brand']); ?></td>
                            <td><?php echo $row['quantity']; ?></td>
                            <td><?php echo htmlspecialchars($row['creator_name']); ?></td>
                            <td><?php echo date('Y-m-d H:i', strtotime($row['date'])); ?></td>
                            <td>
                                <div class="btn-group">
                                    <a href="edit_product.php?id=<?php echo $row['id']; ?>" 
                                       class="btn btn-sm btn-warning" 
                                       title="Edit Product">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="manage_gallery.php?id=<?php echo $row['id']; ?>" 
                                       class="btn btn-sm btn-info" 
                                       title="Manage Gallery">
                                        <i class="fas fa-images"></i>
                                    </a>
                                    <button onclick="confirmDelete(<?php echo $row['id']; ?>)" 
                                            class="btn btn-sm btn-danger" 
                                            title="Delete Product">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        function confirmDelete(productId) {
            if (confirm('Are you sure you want to delete this product? This will also delete all gallery images.')) {
                window.location.href = 'delete_product.php?id=' + productId;
            }
        }
    </script>
</body>
</html>
