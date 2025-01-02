<?php
require_once 'functions.php';
requireLogin();

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if (!$id) {
    header('Location: products.php');
    exit;
}

// Get product details
$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$product = $stmt->get_result()->fetch_assoc();

if (!$product) {
    displayAlert('Product not found', 'danger');
    header('Location: products.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_name = trim($_POST['product_name']);
    $brand = trim($_POST['brand']);
    $quantity = (int)$_POST['quantity'];
    
    if (empty($product_name) || empty($brand) || $quantity < 0) {
        displayAlert('Please fill in all required fields correctly', 'danger');
    } else {
        $image_url = $product['image_url'];
        
        // Handle main product image upload
        if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] === UPLOAD_ERR_OK) {
            $new_image_url = handleImageUpload($_FILES['product_image'], 'products');
            if ($new_image_url) {
                // Delete old image if it exists
                if ($image_url && file_exists($image_url)) {
                    unlink($image_url);
                }
                $image_url = $new_image_url;
            }
        }

        // Update product
        $stmt = $conn->prepare("UPDATE products SET product_name = ?, brand = ?, quantity = ?, image_url = ? WHERE id = ?");
        $stmt->bind_param("ssisi", $product_name, $brand, $quantity, $image_url, $id);
        
        if ($stmt->execute()) {
            // Handle gallery images
            if (isset($_FILES['gallery_images'])) {
                $gallery_images = reArrayFiles($_FILES['gallery_images']);
                foreach ($gallery_images as $image) {
                    if ($image['error'] === UPLOAD_ERR_OK) {
                        $gallery_url = handleImageUpload($image, 'gallery');
                        if ($gallery_url) {
                            $stmt = $conn->prepare("INSERT INTO product_images (product_id, image_url) VALUES (?, ?)");
                            $stmt->bind_param("is", $id, $gallery_url);
                            $stmt->execute();
                        }
                    }
                }
            }
            
            displayAlert('Product updated successfully', 'success');
            header('Location: products.php');
            exit;
        } else {
            displayAlert('Error updating product', 'danger');
        }
    }
}

// Get gallery images
$stmt = $conn->prepare("SELECT * FROM product_images WHERE product_id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$gallery_images = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Product</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .preview-image {
            max-width: 200px;
            max-height: 200px;
            margin: 10px;
            border-radius: 5px;
        }
        #gallery-preview, #existing-gallery {
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
            <h2>Edit Product</h2>
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
                        <input type="text" 
                               class="form-control" 
                               id="product_name" 
                               name="product_name" 
                               value="<?php echo htmlspecialchars($product['product_name']); ?>"
                               required>
                        <div class="invalid-feedback">
                            Please provide a product name.
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="brand">Brand *</label>
                        <input type="text" 
                               class="form-control" 
                               id="brand" 
                               name="brand" 
                               value="<?php echo htmlspecialchars($product['brand']); ?>"
                               required>
                        <div class="invalid-feedback">
                            Please provide a brand name.
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="quantity">Quantity *</label>
                        <input type="number" 
                               class="form-control" 
                               id="quantity" 
                               name="quantity" 
                               value="<?php echo (int)$product['quantity']; ?>"
                               min="0" 
                               required>
                        <div class="invalid-feedback">
                            Please provide a valid quantity.
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Current Main Image</label>
                        <?php if ($product['image_url']): ?>
                            <div class="preview-container">
                                <img src="<?php echo $product['image_url']; ?>" class="preview-image" alt="Current product image">
                            </div>
                        <?php else: ?>
                            <p class="text-muted">No image uploaded</p>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label for="product_image">Change Main Image</label>
                        <div class="custom-file">
                            <input type="file" 
                                   class="custom-file-input" 
                                   id="product_image" 
                                   name="product_image"
                                   accept="image/*"
                                   onchange="previewMainImage(this);">
                            <label class="custom-file-label" for="product_image">Choose file</label>
                        </div>
                        <div id="main-preview" class="mt-2"></div>
                    </div>

                    <div class="form-group">
                        <label>Current Gallery Images</label>
                        <div id="existing-gallery">
                            <?php foreach ($gallery_images as $image): ?>
                                <div class="preview-container">
                                    <img src="<?php echo $image['image_url']; ?>" class="preview-image" alt="Gallery image">
                                    <span class="remove-preview" onclick="deleteGalleryImage(<?php echo $image['id']; ?>, this)">×</span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="gallery_images">Add Gallery Images</label>
                        <div class="custom-file">
                            <input type="file" 
                                   class="custom-file-input" 
                                   id="gallery_images" 
                                   name="gallery_images[]"
                                   accept="image/*"
                                   multiple
                                   onchange="previewGalleryImages(this);">
                            <label class="custom-file-label" for="gallery_images">Choose files</label>
                        </div>
                        <div id="gallery-preview" class="mt-2"></div>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Product
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

        // Update file input label
        $('.custom-file-input').on('change', function() {
            let fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').html(fileName);
        });

        // Preview main image
        function previewMainImage(input) {
            const preview = document.getElementById('main-preview');
            preview.innerHTML = '';
            
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
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
                    
                    reader.onload = function(e) {
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

        // Delete gallery image
        function deleteGalleryImage(imageId, element) {
            if (confirm('Are you sure you want to delete this image?')) {
                $.post('delete_gallery_image.php', { id: imageId }, function(response) {
                    if (response.success) {
                        $(element).parent().remove();
                    } else {
                        alert('Error deleting image');
                    }
                }, 'json');
            }
        }
    </script>
</body>
</html>
