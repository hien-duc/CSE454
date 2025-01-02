<?php
require_once 'functions.php';

// If already logged in, redirect based on user type
if (isLoggedIn()) {
    $user = getCurrentUser();
    if ($user['type'] === 'admin') {
        header('Location: users.php');
    } else {
        header('Location: products.php');
    }
    exit;
}

// Handle registration form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $confirm_password = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';
    $fullname = isset($_POST['fullname']) ? trim($_POST['fullname']) : '';
    $phone_number = isset($_POST['phone_number']) ? trim($_POST['phone_number']) : null;
    $address = isset($_POST['address']) ? trim($_POST['address']) : null;

    // Basic validation
    if (empty($email) || empty($password) || empty($confirm_password) || empty($fullname)) {
        $error = 'Email, Password, and Full Name are required.';
    } elseif ($password !== $confirm_password) {
        $error = 'Passwords do not match.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address.';
    } else {
        // Check if email already exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        if ($stmt->get_result()->num_rows > 0) {
            $error = 'Email already exists.';
        } else {
            // Hash password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert new user
            $stmt = $conn->prepare("INSERT INTO users (email, password, fullname, phone_number, address, type) VALUES (?, ?, ?, ?, ?, 'normal')");
            $stmt->bind_param("sssss", $email, $hashed_password, $fullname, $phone_number, $address);

            if ($stmt->execute()) {
                // Set success message and redirect to login
                $_SESSION['success'] = 'Registration successful! Please login.';
                header('Location: login.php');
                exit;
            } else {
                $error = 'Registration failed. Please try again.';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Register - User Management System</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            padding-top: 50px;
        }

        .register-container {
            max-width: 500px;
            margin: 0 auto;
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background: linear-gradient(45deg, #007bff, #6610f2);
            color: white;
            border-radius: 10px 10px 0 0 !important;
            padding: 20px;
        }

        .btn-primary {
            background: linear-gradient(45deg, #007bff, #6610f2);
            border: none;
        }

        .btn-primary:hover {
            background: linear-gradient(45deg, #0056b3, #520dc2);
        }

        .form-control:focus {
            border-color: #6610f2;
            box-shadow: 0 0 0 0.2rem rgba(102, 16, 242, 0.25);
        }

        .register-icon {
            font-size: 2em;
            margin-bottom: 10px;
        }

        .login-link {
            text-align: center;
            margin-top: 15px;
        }

        .back-to-home {
            position: absolute;
            top: 20px;
            left: 20px;
        }

        .required-field::after {
            content: " *";
            color: red;
        }
    </style>
</head>

<body>
    <a href="index.php" class="back-to-home btn btn-outline-primary">
        <i class="fas fa-home"></i> Back to Home
    </a>

    <div class="container register-container">
        <div class="card">
            <div class="card-header text-center">
                <div class="register-icon">
                    <i class="fas fa-user-plus"></i>
                </div>
                <h3 class="mb-0">Register</h3>
            </div>
            <div class="card-body">
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle"></i>
                        <?php echo htmlspecialchars($error); ?>
                    </div>
                <?php endif; ?>

                <form method="post">
                    <div class="form-group">
                        <label for="email" class="required-field">
                            <i class="fas fa-envelope"></i> Email
                        </label>
                        <input type="email" class="form-control" id="email" name="email"
                            value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="password" class="required-field">
                            <i class="fas fa-lock"></i> Password
                        </label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="form-group">
                        <label for="confirm_password" class="required-field">
                            <i class="fas fa-lock"></i> Confirm Password
                        </label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="fullname" class="required-field">
                            <i class="fas fa-user"></i> Full Name
                        </label>
                        <input type="text" class="form-control" id="fullname" name="fullname"
                            value="<?php echo isset($_POST['fullname']) ? htmlspecialchars($_POST['fullname']) : ''; ?>"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="phone_number">
                            <i class="fas fa-phone"></i> Phone Number
                        </label>
                        <input type="tel" class="form-control" id="phone_number" name="phone_number"
                            value="<?php echo isset($_POST['phone_number']) ? htmlspecialchars($_POST['phone_number']) : ''; ?>">
                    </div>
                    <div class="form-group">
                        <label for="address">
                            <i class="fas fa-map-marker-alt"></i> Address
                        </label>
                        <textarea class="form-control" id="address" name="address"
                            rows="3"><?php echo isset($_POST['address']) ? htmlspecialchars($_POST['address']) : ''; ?></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">
                        <i class="fas fa-user-plus"></i> Register
                    </button>
                </form>

                <div class="login-link">
                    <p class="mb-0">Already have an account?
                        <a href="login.php">Login here</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>