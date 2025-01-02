<?php
$serverName = "localhost";
$userName = "root";
$password = "";
$dbName = "product";
$port = 3306;
// Check submit method
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    //Check any params are submited
    if (isset($_GET["ProductName"])) { // Get values from browser 
        $productName = $_GET["ProductName"];
        $brand = $_GET["Brand"];
        $quantity = $_GET["Quantity"];
        $date = $_GET["Date"];
        $imageUrl = $_GET["ImageUrl"];
        //echo "$productName: $brand: $quantity";

        //Insert them to DB
        $conn = mysqli_connect($serverName, $userName, $password, $dbName);
        if (!$conn) {
            die("Connection failed.");
        }
        
        mysqli_set_charset($conn, "utf8");


        $sql = "INSERT INTO `product` (`product_name`, `brand`, `quantity`, `date`, `image_url`)
VALUES ('$productName', '$brand', $quantity, '$date', '$imageUrl')";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            $lastID = mysqli_insert_id($conn);
            echo "Your Product is inserted. ID = $lastID";
        } else {
            echo "Error.";
        }
        mysqli_close($conn);
        // header("Location: http://localhost/cse454/index.php"); 
        header("refresh:3;url=http://localhost/product/index.php");
    }
}
?>

<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1,
shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        crossorigin="anonymous">
    <title>Adding book - Lib</title>
</head>

<body>
    <div class="container">
        <form method="GET">
            <div class="form-group">
                <label for="">Product Name</label>
                <input type="text" class="form-control" id="ProductName">
            </div>
            <div class="form-group">
                <label for="">Brand</label>
                <input type="text" class="form-control" name="Brand">
            </div>
            <div class="form-group">
                <label for="">Quantity</label>
                <input type="text" class="form-control" name="Quantity">
            </div>
            <div class="form-group">
                <label for="">Date</label>
                <input type="date" class="form-control" name="Date">
            </div>
            <div class="form-group">
                <label for="">Image Url</label>
                <input type="url" class="form-control" name="ImageUrl">
            </div>
            <button type="submit" class="btn btn-primary">Add</button>
        </form>
    </div>
</body>

</html>