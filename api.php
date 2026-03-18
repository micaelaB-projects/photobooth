<?php
// API handlers for photobooth application with MySQL

header('Content-Type: application/json');

// Include database configuration
require_once __DIR__ . '/db_config.php';

// Define uploads directory
$uploadsDir = __DIR__ . '/uploads';

// Ensure uploads directory exists
if (!is_dir($uploadsDir)) {
    mkdir($uploadsDir, 0755, true);
}

// Handle requests
$action = isset($_GET['action']) ? $_GET['action'] : '';

switch ($action) {
    case 'save':
        handleSavePhoto();
        break;
    case 'list':
        handleListPhotos();
        break;
    case 'delete':
        handleDeletePhoto();
        break;
    default:
        echo json_encode(['success' => false, 'error' => 'Invalid action']);
}

/**
 * Save uploaded photo
 */
function handleSavePhoto() {
    global $uploadsDir;
    
    // Check if file was uploaded
    if (!isset($_FILES['photo']) || $_FILES['photo']['error'] !== UPLOAD_ERR_OK) {
        echo json_encode(['success' => false, 'error' => 'No file uploaded or upload error']);
        return;
    }
    
    $tmpFile = $_FILES['photo']['tmp_name'];
    $fileName = $_FILES['photo']['name'];
    
    // Generate unique filename
    $ext = pathinfo($fileName, PATHINFO_EXTENSION);
    $uniqueName = 'photo-' . time() . '-' . uniqid() . '.' . $ext;
    $targetPath = $uploadsDir . '/' . $uniqueName;
    
    // Validate file is actually an image
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mimeType = finfo_file($finfo, $tmpFile);
    finfo_close($finfo);
    
    if (!in_array($mimeType, ['image/jpeg', 'image/png', 'image/webp', 'image/gif'])) {
        echo json_encode(['success' => false, 'error' => 'Invalid image file']);
        return;
    }
    
    // Move uploaded file
    if (move_uploaded_file($tmpFile, $targetPath)) {
        // Resize image if needed (optional)
        resizeImage($targetPath);
        
        // Get image dimensions
        $imageInfo = getimagesize($targetPath);
        $width = $imageInfo[0] ?? 0;
        $height = $imageInfo[1] ?? 0;
        $fileSize = filesize($targetPath);
        
        // Save to database
        $db = getDBConnection();
        $stmt = $db->prepare("INSERT INTO photos (filename, original_name, file_size, width, height, mime_type, upload_path, user_ip) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        
        if (!$stmt) {
            echo json_encode(['success' => false, 'error' => 'Database error: ' . $db->error]);
            return;
        }
        
        $userIp = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
        $stmt->bind_param("ssiiiisss", $uniqueName, $fileName, $fileSize, $width, $height, $mimeType, $targetPath, $userIp);
        
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'filename' => $uniqueName, 'id' => $db->insert_id]);
        } else {
            // Delete file if database insert fails
            unlink($targetPath);
            echo json_encode(['success' => false, 'error' => 'Failed to save photo metadata']);
        }
        
        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'error' => 'Failed to save file']);
    }
}

/**
 * List all photos from database
 */
function handleListPhotos() {
    $db = getDBConnection();
    $photos = [];
    
    // Get limit and offset from query params (for pagination)
    $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 50;
    $offset = isset($_GET['offset']) ? (int)$_GET['offset'] : 0;
    
    // Ensure reasonable limits
    $limit = min($limit, 100);
    $offset = max($offset, 0);
    
    // Query photos from database
    $query = "SELECT id, filename, original_name, width, height, file_size, mime_type, created_at FROM photos WHERE is_deleted = 0 ORDER BY created_at DESC LIMIT ? OFFSET ?";
    $stmt = $db->prepare($query);
    
    if (!$stmt) {
        echo json_encode(['success' => false, 'error' => 'Database error']);
        return;
    }
    
    $stmt->bind_param("ii", $limit, $offset);
    $stmt->execute();
    $result = $stmt->get_result();
    
    while ($row = $result->fetch_assoc()) {
        $photos[] = [
            'id' => $row['id'],
            'filename' => $row['filename'],
            'original_name' => $row['original_name'],
            'width' => $row['width'],
            'height' => $row['height'],
            'size' => $row['file_size'],
            'mime_type' => $row['mime_type'],
            'created_at' => $row['created_at']
        ];
    }
    
    $stmt->close();
    
    // Get total count
    $countQuery = "SELECT COUNT(*) as total FROM photos WHERE is_deleted = 0";
    $countResult = $db->query($countQuery);
    $countRow = $countResult->fetch_assoc();
    $total = $countRow['total'];
    
    echo json_encode([
        'success' => true,
        'photos' => $photos,
        'total' => $total,
        'limit' => $limit,
        'offset' => $offset
    ]);
}

/**
 * Delete a photo (soft delete)
 */
function handleDeletePhoto() {
    $db = getDBConnection();
    
    if (!isset($_GET['filename'])) {
        echo json_encode(['success' => false, 'error' => 'No filename specified']);
        return;
    }
    
    $filename = $_GET['filename'];
    
    // Soft delete: mark as deleted in database
    $stmt = $db->prepare("UPDATE photos SET is_deleted = 1, deleted_at = NOW() WHERE filename = ? AND is_deleted = 0");
    
    if (!$stmt) {
        echo json_encode(['success' => false, 'error' => 'Database error']);
        return;
    }
    
    $stmt->bind_param("s", $filename);
    
    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo json_encode(['success' => true, 'message' => 'Photo deleted']);
        } else {
            echo json_encode(['success' => false, 'error' => 'Photo not found']);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'Failed to delete photo']);
    }
    
    $stmt->close();
}

/**
 * Resize image to prevent storage issues (optional)
 */
function resizeImage($filePath, $maxWidth = 1920, $maxHeight = 1080) {
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mimeType = finfo_file($finfo, $filePath);
    finfo_close($finfo);
    
    // Only process if GD is available
    if (!extension_loaded('gd')) {
        return;
    }
    
    $image = null;
    
    if ($mimeType === 'image/jpeg') {
        $image = imagecreatefromjpeg($filePath);
    } elseif ($mimeType === 'image/png') {
        $image = imagecreatefrompng($filePath);
    } elseif ($mimeType === 'image/webp') {
        $image = imagecreatefromwebp($filePath);
    }
    
    if (!$image) {
        return;
    }
    
    $width = imagesx($image);
    $height = imagesy($image);
    
    // Check if resize is needed
    if ($width <= $maxWidth && $height <= $maxHeight) {
        imagedestroy($image);
        return;
    }
    
    // Calculate new dimensions
    $ratio = min($maxWidth / $width, $maxHeight / $height);
    $newWidth = intval($width * $ratio);
    $newHeight = intval($height * $ratio);
    
    // Create new image
    $resized = imagecreatetruecolor($newWidth, $newHeight);
    imagecopyresampled($resized, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
    
    // Save resized image
    if ($mimeType === 'image/jpeg') {
        imagejpeg($resized, $filePath, 90);
    } elseif ($mimeType === 'image/png') {
        imagepng($resized, $filePath, 9);
    } elseif ($mimeType === 'image/webp') {
        imagewebp($resized, $filePath, 90);
    }
    
    imagedestroy($image);
    imagedestroy($resized);
}
?>
