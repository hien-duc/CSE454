<?php
require_once 'functions.php';

requireAdmin();

if (isset($_GET['delete'])) {
    $userId = $_GET['delete'];
    $sql = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    header('Location: user-management.php');
    exit;
}

if (isset($_GET['toggle_status'])) {
    $userId = $_GET['toggle_status'];
    $sql = "UPDATE users SET status = IF(status='activated', 'disabled', 'activated') WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    header('Location: user-management.php');
    exit;
}

$sql = "SELECT * FROM users";
$result = $conn->query($sql);
$users = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html>

<head>
    <title>User Management</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h1>User Management</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Email</th>
                    <th>Full Name</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Register Date</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo $user['id']; ?></td>
                        <td><?php echo $user['email']; ?></td>
                        <td><?php echo $user['fullname']; ?></td>
                        <td><?php echo $user['phone']; ?></td>
                        <td><?php echo $user['address']; ?></td>
                        <td><?php echo $user['register_date']; ?></td>
                        <td><?php echo $user['user_type']; ?></td>
                        <td><?php echo $user['status']; ?></td>
                        <td>
                            <a href="user-edit.php?id=<?php echo $user['id']; ?>" class="btn btn-primary">Edit</a>
                            <a href="user-management.php?delete=<?php echo $user['id']; ?>" class="btn btn-danger"
                                onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                            <a href="user-management.php?toggle_status=<?php echo $user['id']; ?>" class="btn btn-warning">
                                <?php echo $user['status'] === 'activated' ? 'Disable' : 'Enable'; ?>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>