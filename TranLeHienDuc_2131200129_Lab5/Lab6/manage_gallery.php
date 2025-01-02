<?php
require_once 'functions.php';
requireLogin();

// Get product ID from URL
$product_id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

// Fetch product details
$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->bind_param("i", $product_id);
$stmt->execute();
$product = $stmt->get_result()->fetch_assoc();

// Check if product exists and user has permission
if (!$product) {
    displayAlert('Product not found', 'danger');
    header('Location: products.php');
    exit;
}

$user = getCurrentUser();
if ($user['type'] !== 'admin' && $product['user_id'] !== $user['id']) {
    displayAlert('You do not have permission to manage this product', 'danger');
    header('Location: products.php');
    exit;
}

// Handle image upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['gallery_images'])) {
    $gallery_images = reArrayFiles($_FILES['gallery_images']);
    $success_count = 0;

    foreach ($gallery_images as $image) {
        if ($image['error'] === UPLOAD_ERR_OK) {
            $gallery_url = handleImageUpload($image, 'gallery');
            if ($gallery_url) {
                $stmt = $conn->prepare("INSERT INTO product_images (product_id, image_url) VALUES (?, ?)");
                $stmt->bind_param("is", $product_id, $gallery_url);
                if ($stmt->execute()) {
                    $success_count++;
                }
            }
        }
    }

    if ($success_count > 0) {
        displayAlert($success_count . ' image(s) uploaded successfully', 'success');
    } else {
        displayAlert('No images were uploaded', 'warning');
    }

    // Redirect to refresh the page
    header('Location: manage_gallery.php?id=' . $product_id);
    exit;
}

// Fetch existing gallery images
$stmt = $conn->prepare("SELECT * FROM product_images WHERE product_id = ?");
$stmt->bind_param("i", $product_id);
$stmt->execute();
$gallery_images = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Manage Gallery - <?php echo htmlspecialchars($product['product_name']); ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .gallery-image {
            position: relative;
            margin-bottom: 20px;
        }

        .gallery-image img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 8px;
        }

        .delete-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: rgba(255, 0, 0, 0.7);
            color: white;
            border: none;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .delete-btn:hover {
            background-color: rgba(255, 0, 0, 0.9);
        }

        #preview-container img {
            max-width: 200px;
            max-height: 200px;
            margin: 5px;
            border-radius: 4px;
        }
    </style>
</head>

<body>
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Manage Gallery: <?php echo htmlspecialchars($product['product_name']); ?></h2>
            <a href="products.php" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Products
            </a>
        </div>

        <?php echo showAlert(); ?>

        <!-- Upload Form -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Upload New Images</h5>
            </div>
            <div class="card-body">
                <form method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="gallery_images">Select Images</label>
                        <input type="file" class="form-control-file" id="gallery_images" name="gallery_images[]"
                            multiple accept="image/*" onchange="previewImages(event)">
                    </div>
                    <div id="preview-container" class="mb-3"></div>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-upload"></i> Upload Images
                    </button>
                </form>
            </div>
        </div>

        <!-- Gallery Grid -->
        <div class="row">
            <?php foreach ($gallery_images as $image): ?>
                <div class="col-md-4 gallery-image">
                    <img src="<?php echo htmlspecialchars($image['image_url']); ?>" alt="Gallery Image">
                    <button class="delete-btn" onclick="deleteImage(<?php echo $image['id']; ?>)">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        function previewImages(event) {
            const preview = document.getElementById('preview-container');
            preview.innerHTML = '';

            Array.from(event.target.files).forEach(file => {
                const reader = new FileReader();
                reader.onload = function (e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    preview.appendChild(img);
                }
                reader.readAsDataURL(file);
            });
        }

        function deleteImage(imageId) {
            if (confirm('Are you sure you want to delete this image?')) {
                window.location.href = 'delete_gallery_image.php?id=' + imageId + '&product_id=<?php echo $product_id; ?>';
            }
        }
    </script>
</body>

</html>