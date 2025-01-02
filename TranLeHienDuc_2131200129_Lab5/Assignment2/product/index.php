<?php
require_once 'functions.php';


requireLogin();


$sql = "SELECT p.*, u.fullname AS creator_name 
        FROM products p
        JOIN users u ON p.user_id = u.id";
$result = $conn->query($sql);
$products = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Product Management</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h1>Product Management</h1>
        <a href="add-product.php" class="btn btn-primary mb-3">Add Product</a>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Product Name</th>
                    <th>Brand</th>
                    <th>Quantity</th>
                    <th>Date</th>
                    <th>Image</th>
                    <th>Creator</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?php echo $product['id']; ?></td>
                        <td><?php echo $product['product_name']; ?></td>
                        <td><?php echo $product['brand']; ?></td>
                        <td><?php echo $product['quantity']; ?></td>
                        <td><?php echo $product['date']; ?></td>
                        <td><img src="<?php echo $product['image_url']; ?>" alt="<?php echo $product['product_name']; ?>"
                                width="50"></td>
                        <td><?php echo $product['creator_name']; ?></td>
                        <td>
                            <a href="edit-product.php?id=<?php echo $product['id']; ?>" class="btn btn-primary">Edit</a>
                            <!-- <?php if (isAuthorized($product['user_id'])): ?>

                            <?php endif; ?> -->
                            <a href="delete-product.php?id=<?php echo $product['id']; ?>" class="btn btn-danger"
                                onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>