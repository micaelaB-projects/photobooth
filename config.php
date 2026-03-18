<?php
/**
 * Photobooth Configuration File
 * Customize settings here
 */

// Upload settings
define('MAX_FILE_SIZE', 5242880); // 5MB in bytes
define('ALLOWED_EXTENSIONS', ['jpg', 'jpeg', 'png', 'webp', 'gif']);
define('ALLOWED_MIME_TYPES', ['image/jpeg', 'image/png', 'image/webp', 'image/gif']);

// Image settings
define('IMAGE_MAX_WIDTH', 1920);
define('IMAGE_MAX_HEIGHT', 1080);
define('JPEG_QUALITY', 90);
define('PNG_COMPRESSION', 9);

// Gallery settings
define('PHOTOS_PER_PAGE', 20);
define('AUTO_DELETE_DAYS', 0); // 0 = never auto-delete, set number of days to auto-delete old photos

// Security settings
define('ENABLE_DOWNLOAD_LOG', false); // Log all downloads
define('ENABLE_DELETE_LOG', false);   // Log all deletions
define('ENABLE_UPLOAD_LOG', true);    // Log all uploads

// Camera settings (passed to browser)
$cameraConfig = [
    'facingMode' => 'user', // 'user' or 'environment'
    'idealWidth' => 1280,
    'idealHeight' => 720,
];

// Application title and branding
define('APP_TITLE', 'Online Photobooth');
define('APP_DESCRIPTION', 'Capture and share your memories');

// Enable/Disable features
define('ENABLE_GALLERY', true);
define('ENABLE_DOWNLOAD', true);
define('ENABLE_DELETE', true);
define('ENABLE_IMAGE_RESIZE', true);

?>
