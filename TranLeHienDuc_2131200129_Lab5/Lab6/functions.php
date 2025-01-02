<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'config.php';

function hashPassword($password)
{
    return password_hash($password, PASSWORD_DEFAULT);
}

function verifyPassword($password, $hashedPassword)
{
    return password_verify($password, $hashedPassword);
}

// Session management functions
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function requireLogin()
{
    if (!isLoggedIn()) {
        header('Location: login.php');
        exit;
    }
}

function getCurrentUser() {
    global $conn;
    if (!isLoggedIn()) {
        return null;
    }
    
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

function updatePassword($user_id, $current_password, $new_password) {
    global $conn;
    
    // Get current user
    $stmt = $conn->prepare("SELECT password FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();
    
    // Verify current password
    if (!verifyPassword($current_password, $user['password'])) {
        return false;
    }
    
    // Hash new password
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
    
    // Update password
    $stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
    $stmt->bind_param("si", $hashed_password, $user_id);
    return $stmt->execute();
}

function requireAdmin()
{
    if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'admin') {
        header('Location: index.php');
        exit;
    }
}

function isAuthorized()
{
    return isset($_SESSION['user_id']) &&
        ($_SESSION['user_type'] === 'admin' ||
            $_SESSION['user_type'] === 'author' ||
            $_SESSION['user_type'] === 'normal');
}

function uploadImage($file, $directory)
{
    if (!isset($file['error']) || is_array($file['error'])) {
        throw new RuntimeException('Invalid parameters.');
    }

    switch ($file['error']) {
        case UPLOAD_ERR_OK:
            break;
        case UPLOAD_ERR_NO_FILE:
            throw new RuntimeException('No file sent.');
        case UPLOAD_ERR_INI_SIZE:
        case UPLOAD_ERR_FORM_SIZE:
            throw new RuntimeException('Exceeded filesize limit.');
        default:
            throw new RuntimeException('Unknown errors.');
    }

    if ($file['size'] > MAX_FILE_SIZE) {
        throw new RuntimeException('Exceeded filesize limit.');
    }

    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime_type = $finfo->file($file['tmp_name']);

    $allowed_types = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/gif' => 'gif'
    ];

    if (!array_key_exists($mime_type, $allowed_types)) {
        throw new RuntimeException('Invalid file format.');
    }

    $extension = $allowed_types[$mime_type];
    $filename = sprintf('%s.%s', sha1_file($file['tmp_name']), $extension);
    $uploadPath = UPLOAD_DIR . $directory . '/' . $filename;

    if (!move_uploaded_file($file['tmp_name'], $uploadPath)) {
        throw new RuntimeException('Failed to move uploaded file.');
    }

    return 'uploads/' . $directory . '/' . $filename;
}

function deleteImage($filepath)
{
    $fullPath = __DIR__ . '/' . $filepath;
    if (file_exists($fullPath)) {
        unlink($fullPath);
    }
}

function getFileExtension($filename)
{
    return strtolower(pathinfo($filename, PATHINFO_EXTENSION));
}

function displayAlert($message, $type = 'success')
{
    $_SESSION['alert'] = [
        'message' => $message,
        'type' => $type
    ];
}

function showAlert()
{
    if (isset($_SESSION['alert'])) {
        $alert = $_SESSION['alert'];
        echo "<div class='alert alert-{$alert['type']} alert-dismissible fade show' role='alert'>
                {$alert['message']}
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
              </div>";
        unset($_SESSION['alert']);
    }
}

function handleImageUpload($file, $folder) {
    // Create upload directory if it doesn't exist
    $upload_dir = "uploads/{$folder}/";
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    // Generate unique filename
    $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $filename = uniqid() . '_' . time() . '.' . $extension;
    $target_path = $upload_dir . $filename;

    // Validate file type
    $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
    if (!in_array($extension, $allowed_types)) {
        displayAlert('Invalid file type. Only JPG, JPEG, PNG and GIF are allowed.', 'danger');
        return false;
    }

    // Validate file size (max 5MB)
    if ($file['size'] > 5 * 1024 * 1024) {
        displayAlert('File size too large. Maximum size is 5MB.', 'danger');
        return false;
    }

    // Move uploaded file
    if (move_uploaded_file($file['tmp_name'], $target_path)) {
        return $target_path;
    }

    displayAlert('Error uploading file.', 'danger');
    return false;
}

function reArrayFiles($file_post) {
    $file_array = array();
    $file_count = count($file_post['name']);
    $file_keys = array_keys($file_post);

    for ($i = 0; $i < $file_count; $i++) {
        foreach ($file_keys as $key) {
            $file_array[$i][$key] = $file_post[$key][$i];
        }
    }

    return $file_array;
}
?>