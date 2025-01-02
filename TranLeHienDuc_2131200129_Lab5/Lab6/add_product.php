<?php
require_once 'functions.php';
requireLogin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_name = trim($_POST['product_name']);
    $brand = trim($_POST['brand']);
    $quantity = (int) $_POST['quantity'];
    $user_id = $_SESSION['user_id'];

    // Validate input
    if (empty($product_name) || empty($brand) || $quantity < 0) {
        displayAlert('Please fill in all required fields correctly', 'danger');
    } else {
        // Handle main product image upload
        $image_url = '';
        if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] === UPLOAD_ERR_OK) {
            $image_url = handleImageUpload($_FILES['product_image'], 'products');
            if (!$image_url) {
                displayAlert('Error uploading product image', 'danger');
                $image_url = '';
            }
        }

        // Insert product
        $stmt = $conn->prepare("INSERT INTO products (product_name, brand, quantity, image_url, user_id, date) VALUES (?, ?, ?, ?, ?, NOW())");
        $stmt->bind_param("ssisi", $product_name, $brand, $quantity, $image_url, $user_id);

        if ($stmt->execute()) {
            $product_id = $stmt->insert_id;

            // Handle gallery images
            if (isset($_FILES['gallery_images'])) {
                $gallery_images = reArrayFiles($_FILES['gallery_images']);
                foreach ($gallery_images as $image) {
                    if ($image['error'] === UPLOAD_ERR_OK) {
                        $gallery_url = handleImageUpload($image, 'gallery');
                        if ($gallery_url) {
                            $stmt = $conn->prepare("INSERT INTO product_images (product_id, image_url) VALUES (?, ?)");
                            $stmt->bind_param("is", $product_id, $gallery_url);
                            $stmt->execute();
                        }
                    }
                }
            }

            displayAlert('Product added successfully', 'success');
            header('Location: products.php');
            exit;
        } else {
            displayAlert('Error adding product', 'danger');
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Add Product</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .preview-image {
            max-width: 200px;
            max-height: 200px;
            margin: 10px;
            border-radius: 5px;
        }

        #gallery-preview {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 10px;
        }

        .preview-container {
            position: relative;
            display: inline-block;
        }

        .remove-preview {
            position: absolute;
            top: -10px;
            right: -10px;
            background: red;
            color: white;
            border-radius: 50%;
            padding: 5px 8px;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Add New Product</h2>
            <a href="products.php" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Products
            </a>
        </div>

        <?php showAlert(); ?>

        <div class="card">
            <div class="card-body">
                <form method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                    <div class="form-group">
                        <label for="product_name">Product Name *</label>
                        <input type="text" class="form-control" id="product_name" name="product_name"
                            value="<?php echo isset($_POST['product_name']) ? htmlspecialchars($_POST['product_name']) : ''; ?>"
                            required>
                        <div class="invalid-feedback">
                            Please provide a product name.
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="brand">Brand *</label>
                        <input type="text" class="form-control" id="brand" name="brand"
                            value="<?php echo isset($_POST['brand']) ? htmlspecialchars($_POST['brand']) : ''; ?>"
                            required>
                        <div class="invalid-feedback">
                            Please provide a brand name.
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="quantity">Quantity *</label>
                        <input type="number" class="form-control" id="quantity" name="quantity"
                            value="<?php echo isset($_POST['quantity']) ? (int) $_POST['quantity'] : 0; ?>" min="0"
                            required>
                        <div class="invalid-feedback">
                            Please provide a valid quantity.
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="product_image">Main Product Image</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="product_image" name="product_image"
                                accept="image/*" onchange="previewMainImage(this);">
                            <label class="custom-file-label" for="product_image">Choose file</label>
                        </div>
                        <div id="main-preview" class="mt-2"></div>
                    </div>

                    <div class="form-group">
                        <label for="gallery_images">Gallery Images</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="gallery_images" name="gallery_images[]"
                                accept="image/*" multiple onchange="previewGalleryImages(this);">
                            <label class="custom-file-label" for="gallery_images">Choose files</label>
                        </div>
                        <div id="gallery-preview" class="mt-2"></div>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Save Product
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        // Form validation
        (function () {
            'use strict';
            window.addEventListener('load', function () {
                var forms = document.getElementsByClassName('needs-validation');
                var validation = Array.prototype.filter.call(forms, function (form) {
                    form.addEventListener('submit', function (event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();

        // Update file input label
        $('.custom-file-input').on('change', function () {
            let fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').html(fileName);
        });

        // Preview main image
        function previewMainImage(input) {
            const preview = document.getElementById('main-preview');
            preview.innerHTML = '';

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function (e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.classList.add('preview-image');
                    preview.appendChild(img);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        // Preview gallery images
        function previewGalleryImages(input) {
            const preview = document.getElementById('gallery-preview');
            preview.innerHTML = '';

            if (input.files) {
                Array.from(input.files).forEach(file => {
                    const reader = new FileReader();

                    reader.onload = function (e) {
                        const container = document.createElement('div');
                        container.classList.add('preview-container');

                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.classList.add('preview-image');

                        container.appendChild(img);
                        preview.appendChild(container);
                    }

                    reader.readAsDataURL(file);
                });
            }
        }
    </script>
</body>

</html>