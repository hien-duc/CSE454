<?php
require_once 'functions.php';

requireLogin();


$userId = $_GET['id'];


$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!isAuthorized($userId) && $_SESSION['user_type'] !== 'admin') {
    header('Location: index.php');
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $fullname = $_POST['fullname'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $userType = $_POST['user_type'];
    $status = $_POST['status'];

    // Update user details in the database
    $sql = "UPDATE users SET 
            email = ?,
            fullname = ?,
            phone = ?,
            address = ?,
            user_type = ?,
            status = ?
            WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssi", $email, $fullname, $phone, $address, $userType, $status, $userId);
    $stmt->execute();

    // Redirect back to the user management page
    header('Location: user-management.php');
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit User</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h1>Edit User</h1>
        <form method="post">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo $user['email']; ?>" required>
            </div>
            <div class="form-group">
                <label for="fullname">Full Name</label>
                <input type="text" class="form-control" id="fullname" name="fullname" value="<?php echo $user['fullname']; ?>" required>
            </div>
            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $user['phone']; ?>" required>
            </div>
            <div class="form-group">
                <label for="address">Address</label>
                <textarea class="form-control" id="address" name="address" required><?php echo $user['address']; ?></textarea>
            </div>
            <div class="form-group">
                <label for="user_type">User Type</label>
                <select class="form-control" id="user_type" name="user_type" required>
                    <option value="admin" <?php echo $user['user_type'] === 'admin' ? 'selected' : ''; ?>>Admin</option>
                    <option value="author" <?php echo $user['user_type'] === 'author' ? 'selected' : ''; ?>>Author</option>
                    <option value="normal" <?php echo $user['user_type'] === 'normal' ? 'selected' : ''; ?>>Normal</option>
                </select>
            </div>
            <div class="form-group">
                <label for="status">Status</label>
                <select class="form-control" id="status" name="status" required>
                    <option value="activated" <?php echo $user['status'] === 'activated' ? 'selected' : ''; ?>>Activated</option>
                    <option value="disabled" <?php echo $user['status'] === 'disabled' ? 'selected' : ''; ?>>Disabled</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update User</button>
            <a href="user-management.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>

</html>
