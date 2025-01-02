<?php
require_once 'functions.php';
requireAdmin();

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: users.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $fullname = $_POST['fullname'];
    $phone_number = $_POST['phone_number'];
    $address = $_POST['address'];
    $type = $_POST['type'];
    $status = $_POST['status'];

    $sql = "UPDATE users SET email = ?, fullname = ?, phone_number = ?, address = ?, type = ?, status = ?";
    $params = [$email, $fullname, $phone_number, $address, $type, $status];
    $types = "ssssss";

    // Only update password if a new one is provided
    if (!empty($_POST['password'])) {
        $password = hashPassword($_POST['password']);
        $sql .= ", password = ?";
        $params[] = $password;
        $types .= "s";
    }

    $sql .= " WHERE id = ?";
    $params[] = $id;
    $types .= "i";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param($types, ...$params);
    
    if ($stmt->execute()) {
        header('Location: users.php');
        exit;
    } else {
        $error = "Error updating user: " . $conn->error;
    }
}

// Get current user data
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

if (!$user) {
    header('Location: users.php');
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
    <div class="container mt-4">
        <h2>Edit User</h2>
        
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            </div>

            <div class="form-group">
                <label>Password (leave blank to keep current)</label>
                <input type="password" name="password" class="form-control">
            </div>

            <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="fullname" class="form-control" value="<?php echo htmlspecialchars($user['fullname']); ?>" required>
            </div>

            <div class="form-group">
                <label>Phone Number</label>
                <input type="text" name="phone_number" class="form-control" value="<?php echo htmlspecialchars($user['phone_number']); ?>">
            </div>

            <div class="form-group">
                <label>Address</label>
                <textarea name="address" class="form-control" rows="3"><?php echo htmlspecialchars($user['address']); ?></textarea>
            </div>

            <div class="form-group">
                <label>User Type</label>
                <select name="type" class="form-control" required>
                    <option value="admin" <?php echo $user['type'] === 'admin' ? 'selected' : ''; ?>>Admin</option>
                    <option value="author" <?php echo $user['type'] === 'author' ? 'selected' : ''; ?>>Author</option>
                    <option value="normal" <?php echo $user['type'] === 'normal' ? 'selected' : ''; ?>>Normal User</option>
                </select>
            </div>

            <div class="form-group">
                <label>Status</label>
                <select name="status" class="form-control" required>
                    <option value="activated" <?php echo $user['status'] === 'activated' ? 'selected' : ''; ?>>Activated</option>
                    <option value="disabled" <?php echo $user['status'] === 'disabled' ? 'selected' : ''; ?>>Disabled</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Update User</button>
            <a href="users.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>
