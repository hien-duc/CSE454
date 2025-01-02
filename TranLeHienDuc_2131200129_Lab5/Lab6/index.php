<?php
require_once 'functions.php';

// Get current user info if logged in
$user = null;
$isLoggedIn = isLoggedIn();
if ($isLoggedIn) {
    $user = getCurrentUser();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Product Management System</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .welcome-container {
            margin-top: 100px;
        }
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .card-header {
            background: linear-gradient(45deg, #007bff, #6610f2);
            color: white;
            border-radius: 15px 15px 0 0 !important;
            padding: 30px;
        }
        .card-body {
            padding: 40px;
        }
        .feature-icon {
            font-size: 24px;
            margin-bottom: 15px;
            color: #007bff;
        }
        .feature-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .feature-text {
            color: #6c757d;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <i class="fas fa-box-open"></i> Product Management
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="products.php">Products</a>
                    </li>
                    <?php if ($isLoggedIn && $user['type'] === 'admin'): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="users.php">User Management</a>
                    </li>
                    <?php endif; ?>
                </ul>
                <ul class="navbar-nav">
                    <?php if ($isLoggedIn): ?>
                        <li class="nav-item">
                            <span class="nav-link">Welcome, <?php echo htmlspecialchars($user['email']); ?></span>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">Logout</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="login.php">Login</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container welcome-container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-center">
                        <h1 class="display-4 mb-0">
                            <i class="fas fa-box-open"></i>
                            Product Management System
                        </h1>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-4">
                            <p class="lead">
                                Welcome to our comprehensive product management system. 
                                Please login to access the features.
                            </p>
                            <a href="login.php" class="btn btn-primary btn-lg">
                                <i class="fas fa-sign-in-alt"></i> Login
                            </a>
                        </div>

                        <hr>

                        <div class="row mt-4">
                            <div class="col-md-4 text-center">
                                <div class="feature-icon">
                                    <i class="fas fa-user-shield"></i>
                                </div>
                                <div class="feature-title">
                                    Secure Access
                                </div>
                                <div class="feature-text">
                                    Role-based access control with secure authentication
                                </div>
                            </div>
                            <div class="col-md-4 text-center">
                                <div class="feature-icon">
                                    <i class="fas fa-boxes"></i>
                                </div>
                                <div class="feature-title">
                                    Product Management
                                </div>
                                <div class="feature-text">
                                    Comprehensive product and inventory tracking
                                </div>
                            </div>
                            <div class="col-md-4 text-center">
                                <div class="feature-icon">
                                    <i class="fas fa-images"></i>
                                </div>
                                <div class="feature-title">
                                    Image Gallery
                                </div>
                                <div class="feature-text">
                                    Multiple image upload with gallery management
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-4 text-center">
                                <div class="feature-icon">
                                    <i class="fas fa-users-cog"></i>
                                </div>
                                <div class="feature-title">
                                    User Management
                                </div>
                                <div class="feature-text">
                                    Complete user administration system
                                </div>
                            </div>
                            <div class="col-md-4 text-center">
                                <div class="feature-icon">
                                    <i class="fas fa-user-edit"></i>
                                </div>
                                <div class="feature-title">
                                    Profile Management
                                </div>
                                <div class="feature-text">
                                    Update personal information and settings
                                </div>
                            </div>
                            <div class="col-md-4 text-center">
                                <div class="feature-icon">
                                    <i class="fas fa-mobile-alt"></i>
                                </div>
                                <div class="feature-title">
                                    Responsive Design
                                </div>
                                <div class="feature-text">
                                    Works seamlessly on all devices
                                </div>
                            </div>
                        </div>
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
