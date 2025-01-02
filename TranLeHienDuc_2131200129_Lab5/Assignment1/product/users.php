<?php
require_once 'functions.php';
requireAdmin();

$sql = "SELECT * FROM users";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Management</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h2>User Management</h2>
        <a href="add_user.php" class="btn btn-primary mb-3">Add New User</a>
        <a href="index.php" class="btn btn-secondary mb-3">Back to Products</a>
        
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Email</th>
                    <th>Full Name</th>
                    <th>Phone Number</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Date Registered</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $stt = 1;
                while ($row = mysqli_fetch_assoc($result)) { 
                ?>
                <tr>
                    <td><?php echo $stt++; ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><?php echo htmlspecialchars($row['fullname']); ?></td>
                    <td><?php echo htmlspecialchars($row['phone_number']); ?></td>
                    <td><?php echo ucfirst($row['type']); ?></td>
                    <td>
                        <span class="badge badge-<?php echo $row['status'] === 'activated' ? 'success' : 'danger'; ?>">
                            <?php echo ucfirst($row['status']); ?>
                        </span>
                    </td>
                    <td><?php echo $row['date_register']; ?></td>
                    <td>
                        <a href="edit_user.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                        <button class="btn btn-sm btn-danger delete-user" data-id="<?php echo $row['id']; ?>">Delete</button>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.delete-user').click(function() {
                if (confirm('Are you sure you want to delete this user?')) {
                    var id = $(this).data('id');
                    window.location.href = 'delete_user.php?id=' + id;
                }
            });
        });
    </script>
</body>
</html>
