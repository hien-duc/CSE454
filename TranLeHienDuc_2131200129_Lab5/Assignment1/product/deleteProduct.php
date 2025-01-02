<?php
if (isset($_GET['id'])) {
    $serverName = "localhost";
    $userName = "root";
    $dbName = "product";
    $password = "";
    $port = 3306;
    $conn = mysqli_connect($serverName, $userName, $password, $dbName);
    if (!$conn) {
        die("Connection failed.");
    }
    $id = $_GET["id"];
    $sql = "DELETE FROM `product` WHERE product_code=$id";
    mysqli_query($conn, $sql);
    mysqli_close($conn);
    header("Location: http://localhost/product/index.php");
    die();
}
?>