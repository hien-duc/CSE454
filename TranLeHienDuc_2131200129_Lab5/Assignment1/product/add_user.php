<?php
require_once 'functions.php';
requireAdmin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = hashPassword($_POST['password']);
    $fullname = $_POST['fullname'];
    $phone_number = $_POST['phone_number'];
    $address = $_POST['address'];
    $type = $_POST['type'];
    $status = $_POST['status'];

    $sql = "INSERT INTO users (email, password, fullname, phone_number, address, type, status) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssss", $email, $password, $fullname, $phone_number, $address, $type, $status);
    
    if ($stmt->execute()) {
        header('Location: users.php');
        exit;
    } else {
        $error = "Error creating user: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add User</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h2>Add New User</h2>
        
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="fullname" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Phone Number</label>
                <input type="text" name="phone_number" class="form-control">
            </div>

            <div class="form-group">
                <label>Address</label>
                <textarea name="address" class="form-control" rows="3"></textarea>
            </div>

            <div class="form-group">
                <label>User Type</label>
                <select name="type" class="form-control" required>
                    <option value="admin">Admin</option>
                    <option value="author">Author</option>
                    <option value="normal">Normal User</option>
                </select>
            </div>

            <div class="form-group">
                <label>Status</label>
                <select name="status" class="form-control" required>
                    <option value="activated">Activated</option>
                    <option value="disabled">Disabled</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Add User</button>
            <a href="users.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>
