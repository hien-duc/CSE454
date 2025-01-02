<?php
$serverName = "localhost";
$userName = "root";
$password = "";
$dbName = "product";
$conn = mysqli_connect($serverName, $userName, $password, $dbName);

if (!$conn) {
    die("Connection failed.");
}

$id = $_GET['id'];
//$id = intval($_GET['id']);
$sql = "SELECT * FROM `product` WHERE product_code = $id";
$result = mysqli_query($conn, $sql);
$product = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $productName = $_POST['product_name'];
    $quantity = $_POST['quantity'];
    $brand = $_POST['brand'];
    $date = $_POST['date'];
    $imageUrl = $_POST['image_url'];

    $updateSql = "UPDATE `product` SET 
        product_name='$productName', 
        quantity='$quantity', 
        brand='$brand', 
        date='$date', 
        image_url='$imageUrl' 
        WHERE product_code=$id";

    mysqli_query($conn, $updateSql);
    mysqli_close($conn);

    header("Location: index.php");
    exit();
}
?>

<!doctype html>
<html>

<head>
    <title>Update Product</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <h2>Update Product</h2>
        <form method="POST">
            <div class="form-group">
                <label>Product Name</label>
                <input type="text" class="form-control" name="product_name"
                    value="<?php echo $product['product_name']; ?>" required>
            </div>
            <div class="form-group">
                <label>Quantity</label>
                <input type="number" class="form-control" name="quantity" value="<?php echo $product['quantity']; ?>"
                    required>
            </div>
            <div class="form-group">
                <label>Brand</label>
                <input type="text" class="form-control" name="brand" value="<?php echo $product['brand']; ?>" required>
            </div>
            <div class="form-group">
                <label>Date</label>
                <input type="date" class="form-control" name="date" value="<?php echo $product['date']; ?>" required>
            </div>
            <div class="form-group">
                <label>Image URL</label>
                <input type="text" class="form-control" name="image_url" value="<?php echo $product['image_url']; ?>">
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="index.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>

</html>