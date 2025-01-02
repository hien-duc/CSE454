<?php
require_once 'functions.php';
requireLogin();

// Check if user is admin
$currentUser = getCurrentUser();
if ($currentUser['type'] !== 'admin') {
    displayAlert('Access denied. Admin privileges required.', 'danger');
    header('Location: index.php');
    exit;
}

// Get user ID from URL
$user_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if (!$user_id) {
    displayAlert('Invalid user ID', 'danger');
    header('Location: users.php');
    exit;
}

// Get user details
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

if (!$user) {
    displayAlert('User not found', 'danger');
    header('Location: users.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $fullname = trim($_POST['fullname']);
    $phone_number = trim($_POST['phone_number']);
    $address = trim($_POST['address']);
    $type = $_POST['type'];
    $password = trim($_POST['password']);

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        displayAlert('Invalid email format', 'danger');
    } else {
        // Check if email exists for other users
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
        $stmt->bind_param("si", $email, $user_id);
        $stmt->execute();
        if ($stmt->get_result()->num_rows > 0) {
            displayAlert('Email already exists', 'danger');
        } else {
            // Update user
            if (!empty($password)) {
                // Update with new password
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $sql = "UPDATE users SET email = ?, password = ?, fullname = ?, phone_number = ?, address = ?, type = ? WHERE id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssssssi", $email, $hashedPassword, $fullname, $phone_number, $address, $type, $user_id);
            } else {
                // Update without changing password
                $sql = "UPDATE users SET email = ?, fullname = ?, phone_number = ?, address = ?, type = ? WHERE id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sssssi", $email, $fullname, $phone_number, $address, $type, $user_id);
            }

            if ($stmt->execute()) {
                displayAlert('User updated successfully', 'success');
                header('Location: users.php');
                exit;
            } else {
                displayAlert('Error updating user: ' . $conn->error, 'danger');
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit User</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="index.php">Home</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="products.php">Products</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="users.php">User Management</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <span class="nav-link">Welcome, <?php echo htmlspecialchars($currentUser['email']); ?></span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="mb-0">Edit User</h3>
                        <a href="users.php" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to Users
                        </a>
                    </div>
                    <div class="card-body">
                        <?php echo showAlert(); ?>

                        <form method="POST" class="needs-validation" novalidate>
                            <div class="form-group">
                                <label for="email">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="email" name="email" required
                                    value="<?php echo htmlspecialchars($user['email']); ?>">
                            </div>

                            <div class="form-group">
                                <label for="password">New Password</label>
                                <input type="password" class="form-control" id="password" name="password" minlength="6">
                                <small class="form-text text-muted">Leave empty to keep current password. New password must be at least 6 characters long.</small>
                            </div>

                            <div class="form-group">
                                <label for="fullname">Full Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="fullname" name="fullname" required
                                    value="<?php echo htmlspecialchars($user['fullname']); ?>">
                            </div>

                            <div class="form-group">
                                <label for="phone_number">Phone Number</label>
                                <input type="tel" class="form-control" id="phone_number" name="phone_number"
                                    value="<?php echo htmlspecialchars($user['phone_number']); ?>">
                            </div>

                            <div class="form-group">
                                <label for="address">Address</label>
                                <textarea class="form-control" id="address" name="address" rows="3"><?php echo htmlspecialchars($user['address']); ?></textarea>
                            </div>

                            <div class="form-group">
                                <label for="type">User Type <span class="text-danger">*</span></label>
                                <select class="form-control" id="type" name="type" required>
                                    <option value="normal" <?php echo $user['type'] === 'normal' ? 'selected' : ''; ?>>Normal</option>
                                    <option value="author" <?php echo $user['type'] === 'author' ? 'selected' : ''; ?>>Author</option>
                                    <option value="admin" <?php echo $user['type'] === 'admin' ? 'selected' : ''; ?>>Admin</option>
                                </select>
                            </div>

                            <div class="form-group mb-0">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Update User
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
