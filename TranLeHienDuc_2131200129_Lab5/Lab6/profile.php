<?php
require_once 'functions.php';
requireLogin();

$user = getCurrentUser();
$success_message = '';
$error_message = '';

// Handle profile update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_profile'])) {
        $fullname = trim($_POST['fullname']);
        $email = trim($_POST['email']);
        $phone_number = trim($_POST['phone_number']);
        $address = trim($_POST['address']);

        // Validate email uniqueness (excluding current user)
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
        $stmt->bind_param("si", $email, $user['id']);
        $stmt->execute();
        if ($stmt->get_result()->num_rows > 0) {
            displayAlert('Email already exists', 'danger');
        } else {
            // Update profile
            $stmt = $conn->prepare("UPDATE users SET fullname = ?, email = ?, phone_number = ?, address = ? WHERE id = ?");
            $stmt->bind_param("ssssi", $fullname, $email, $phone_number, $address, $user['id']);
            
            if ($stmt->execute()) {
                $_SESSION['user_email'] = $email;
                $_SESSION['user_fullname'] = $fullname;
                displayAlert('Profile updated successfully', 'success');
                $user = getCurrentUser(); // Refresh user data
            } else {
                displayAlert('Error updating profile', 'danger');
            }
        }
    }
    
    // Handle password update
    else if (isset($_POST['update_password'])) {
        $current_password = $_POST['current_password'];
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];

        if ($new_password !== $confirm_password) {
            displayAlert('New passwords do not match', 'danger');
        } else if (strlen($new_password) < 6) {
            displayAlert('New password must be at least 6 characters long', 'danger');
        } else {
            if (updatePassword($user['id'], $current_password, $new_password)) {
                displayAlert('Password updated successfully', 'success');
            } else {
                displayAlert('Current password is incorrect', 'danger');
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Profile</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .profile-section {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            padding: 20px;
            margin-bottom: 20px;
        }
        .section-title {
            border-bottom: 2px solid #f8f9fa;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>My Profile</h2>
            <div>
                <a href="products.php" class="btn btn-primary">
                    <i class="fas fa-box"></i> Products
                </a>
                <?php if ($_SESSION['user_type'] === 'admin'): ?>
                    <a href="users.php" class="btn btn-info">
                        <i class="fas fa-users"></i> Users
                    </a>
                <?php endif; ?>
                <a href="logout.php" class="btn btn-secondary">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </div>

        <?php showAlert(); ?>

        <div class="row">
            <div class="col-md-6">
                <div class="profile-section">
                    <h4 class="section-title">
                        <i class="fas fa-user"></i> Account Details
                    </h4>
                    <form method="POST" class="needs-validation" novalidate>
                        <input type="hidden" name="update_profile" value="1">
                        
                        <div class="form-group">
                            <label for="fullname">Full Name</label>
                            <input type="text" 
                                   class="form-control" 
                                   id="fullname" 
                                   name="fullname" 
                                   value="<?php echo htmlspecialchars($user['fullname']); ?>" 
                                   required>
                            <div class="invalid-feedback">
                                Please provide your full name.
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" 
                                   class="form-control" 
                                   id="email" 
                                   name="email" 
                                   value="<?php echo htmlspecialchars($user['email']); ?>" 
                                   required>
                            <div class="invalid-feedback">
                                Please provide a valid email.
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="phone_number">Phone Number</label>
                            <input type="tel" 
                                   class="form-control" 
                                   id="phone_number" 
                                   name="phone_number" 
                                   value="<?php echo htmlspecialchars($user['phone_number']); ?>">
                        </div>

                        <div class="form-group">
                            <label for="address">Address</label>
                            <textarea class="form-control" 
                                      id="address" 
                                      name="address" 
                                      rows="3"><?php echo htmlspecialchars($user['address']); ?></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update Profile
                        </button>
                    </form>
                </div>
            </div>

            <div class="col-md-6">
                <div class="profile-section">
                    <h4 class="section-title">
                        <i class="fas fa-key"></i> Change Password
                    </h4>
                    <form method="POST" class="needs-validation" novalidate>
                        <input type="hidden" name="update_password" value="1">
                        
                        <div class="form-group">
                            <label for="current_password">Current Password</label>
                            <input type="password" 
                                   class="form-control" 
                                   id="current_password" 
                                   name="current_password" 
                                   required>
                            <div class="invalid-feedback">
                                Please enter your current password.
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="new_password">New Password</label>
                            <input type="password" 
                                   class="form-control" 
                                   id="new_password" 
                                   name="new_password" 
                                   minlength="6" 
                                   required>
                            <div class="invalid-feedback">
                                Password must be at least 6 characters long.
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="confirm_password">Confirm New Password</label>
                            <input type="password" 
                                   class="form-control" 
                                   id="confirm_password" 
                                   name="confirm_password" 
                                   required>
                            <div class="invalid-feedback">
                                Please confirm your new password.
                            </div>
                        </div>

                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-key"></i> Change Password
                        </button>
                    </form>
                </div>

                <div class="profile-section">
                    <h4 class="section-title">
                        <i class="fas fa-info-circle"></i> Account Information
                    </h4>
                    <p><strong>Account Type:</strong> <?php echo ucfirst($user['type']); ?></p>
                    <p><strong>Status:</strong> <?php echo ucfirst($user['status']); ?></p>
                    <p><strong>Registered:</strong> <?php echo date('F j, Y', strtotime($user['date_register'])); ?></p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        // Form validation
        (function() {
            'use strict';
            window.addEventListener('load', function() {
                var forms = document.getElementsByClassName('needs-validation');
                var validation = Array.prototype.filter.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();

        // Password confirmation validation
        document.getElementById('confirm_password').addEventListener('input', function() {
            if (this.value !== document.getElementById('new_password').value) {
                this.setCustomValidity('Passwords do not match');
            } else {
                this.setCustomValidity('');
            }
        });
    </script>
</body>
</html>
