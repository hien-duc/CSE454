<?php
require_once 'functions.php';


requireLogin();


$productId = $_GET['id'];
$sql = "SELECT * FROM products WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $productId);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();


if (!isAuthorized($product['user_id'])) {
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productName = $_POST['product_name'];
    $brand = $_POST['brand'];
    $quantity = $_POST['quantity'];
    $date = $_POST['date'];
    $imageUrl = $_POST['image_url'];

    $sql = "UPDATE products SET 
           product_name = ?,
           brand = ?,
           quantity = ?,
           date = ?,
           image_url = ?
           WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$productName, $brand, $quantity, $date, $imageUrl, $productId]);

    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit Product</title>
    <!-- Include Bootstrap or your preferred CSS framework -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h1>Edit Product</h1>
        <form method="post">
            <div class="form-group">
                <label for="product_name">Product Name</label>
                <input type="text" class="form-control" id="product_name" name="product_name"
                    value="<?php echo $product['product_name']; ?>" required>
            </div>
            <div class="form-group">
                <label for="brand">Brand</label>
                <input type="text" class="form-control" id="brand" name="brand" value="<?php echo $product['brand']; ?>"
                    required>
            </div>
            <div class="form-group">
                <label for="quantity">Quantity</label>
                <input type="number" class="form-control" id="quantity" name="quantity"
                    value="<?php echo $product['quantity']; ?>" required>
            </div>
            <div class="form-group">
                <label for="date">Date</label>
                <input type="date" class="form-control" id="date" name="date" value="<?php echo $product['date']; ?>"
                    required>
            </div>
            <div class="form-group">
                <label for="image_url">Image URL</label>
                <input type="text" class="form-control" id="image_url" name="image_url"
                    value="<?php echo $product['image_url']; ?>">
            </div>
            <button type="submit" class="btn btn-primary">Update Product</button>
            <a href="index.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>

</html>