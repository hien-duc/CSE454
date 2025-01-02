<?php
// Check submit method
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    // Check any params are submited
    if (isset($_GET["BookTitle"])) {
        // Get values from browser
        $bookTitle = $_GET["BookTitle"];
        $authors = $_GET["Authors"];
        $quantity = $_GET["Quantity"];
        echo "$bookTitle: $authors: $quantity";
        // Insert them to DB
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
                <label for="">Book Title</label>
                <input type="text" class="form-control" name="BookTitle">
            </div>
            <div class="form-group">
                <label for="">Authors</label>
                <input type="text" class="form-control" name="Authors">
            </div>
            <div class="form-group">
                <label for="">Quantity</label>
                <input type="text" class="form-control" name="Quantity">
            </div>
            <button type="submit" class="btn btn-primary">Add</button>
        </form>
    </div>
</body>

</html>