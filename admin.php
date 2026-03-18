<?php
/**
 * Admin Dashboard
 * View statistics and manage photobooth data
 */

require_once __DIR__ . '/db_config.php';

$db = getDBConnection();
$stats = [];
$recentPhotos = [];

// Get statistics
$statsQuery = "SELECT 
    COUNT(*) as total_photos,
    SUM(file_size) as total_size,
    MAX(created_at) as latest_photo
    FROM photos WHERE is_deleted = 0";

$statsResult = $db->query($statsQuery);
$stats = $statsResult->fetch_assoc();

// Get recent photos
$photosQuery = "SELECT id, filename, original_name, file_size, width, height, created_at FROM photos WHERE is_deleted = 0 ORDER BY created_at DESC LIMIT 10";
$photosResult = $db->query($photosQuery);

while ($row = $photosResult->fetch_assoc()) {
    $recentPhotos[] = $row;
}

// Get database size
$dbSizeQuery = "SELECT 
    SUM(ROUND(((data_length + index_length) / 1024 / 1024), 2)) as db_size_mb
    FROM information_schema.TABLES 
    WHERE table_schema = '" . DB_NAME . "'";

$dbSizeResult = $db->query($dbSizeQuery);
$dbSize = $dbSizeResult->fetch_assoc();

// Handle actions
$message = '';
if ($_POST['action'] ?? '' === 'clear_deleted') {
    $deleteQuery = "DELETE FROM photos WHERE is_deleted = 1";
    if ($db->query($deleteQuery)) {
        $message = "✓ Deleted photos cleared from database";
    } else {
        $message = "✗ Error clearing deleted photos";
    }
}

if ($_POST['action'] ?? '' === 'cleanup_old') {
    $days = (int)($_POST['days'] ?? 30);
    $deleteQuery = "DELETE FROM photos WHERE is_deleted = 1 AND deleted_at < DATE_SUB(NOW(), INTERVAL $days DAY)";
    if ($db->query($deleteQuery)) {
        $message = "✓ Old photos cleaned up";
    } else {
        $message = "✗ Error cleaning up photos";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Photobooth Admin Dashboard</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        
        header {
            background: white;
            padding: 25px 30px;
            border-radius: 10px;
            margin-bottom: 25px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }
        
        h1 {
            color: #333;
            margin-bottom: 10px;
            font-size: 2em;
        }
        
        .breadcrumb {
            color: #666;
            font-size: 0.95em;
        }
        
        .breadcrumb a {
            color: #667eea;
            text-decoration: none;
        }
        
        .breadcrumb a:hover {
            text-decoration: underline;
        }
        
        .message {
            padding: 15px 20px;
            margin-bottom: 20px;
            border-radius: 5px;
            font-weight: 600;
            animation: slideIn 0.3s ease-out;
        }
        
        .message.success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .message.error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 25px;
        }
        
        .card {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }
        
        .stat-card {
            text-align: center;
        }
        
        .stat-value {
            font-size: 2.5em;
            font-weight: 700;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin: 15px 0;
        }
        
        .stat-label {
            color: #666;
            font-size: 0.95em;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        h2 {
            color: #333;
            margin-bottom: 20px;
            font-size: 1.5em;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        
        thead {
            background: #f5f5f5;
            border-bottom: 2px solid #ddd;
        }
        
        th {
            padding: 15px;
            text-align: left;
            font-weight: 600;
            color: #333;
        }
        
        td {
            padding: 15px;
            border-bottom: 1px solid #eee;
            color: #666;
        }
        
        tr:hover {
            background: #f9f9f9;
        }
        
        .btn {
            display: inline-block;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
        
        .btn-sm {
            padding: 8px 16px;
            font-size: 0.9em;
        }
        
        .maintenance {
            background: #fff3cd;
            border: 1px solid #ffc107;
            padding: 20px;
            border-radius: 8px;
            margin-top: 20px;
        }
        
        .maintenance h3 {
            color: #856404;
            margin-bottom: 15px;
        }
        
        .form-group {
            margin-bottom: 15px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 600;
        }
        
        .form-group input {
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1em;
        }
        
        .db-info {
            background: #f0f8ff;
            padding: 15px;
            border-radius: 5px;
            border-left: 4px solid #667eea;
            margin-top: 15px;
            color: #333;
            font-size: 0.95em;
            line-height: 1.6;
        }
        
        footer {
            text-align: center;
            color: white;
            margin-top: 40px;
            padding: 20px;
        }
        
        footer a {
            color: #fff;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>📊 Photobooth Admin Dashboard</h1>
            <div class="breadcrumb">
                <a href="index.php">← Back to Photobooth</a>
            </div>
        </header>
        
        <?php if (!empty($message)): ?>
            <div class="message success">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
        
        <div class="grid">
            <div class="card stat-card">
                <div class="stat-label">Total Photos</div>
                <div class="stat-value"><?php echo $stats['total_photos'] ?? 0; ?></div>
            </div>
            
            <div class="card stat-card">
                <div class="stat-label">Storage Used</div>
                <div class="stat-value">
                    <?php 
                    $size = ($stats['total_size'] ?? 0) / (1024 * 1024);
                    echo number_format($size, 2) . ' MB';
                    ?>
                </div>
            </div>
            
            <div class="card stat-card">
                <div class="stat-label">Database Size</div>
                <div class="stat-value">
                    <?php echo number_format($dbSize['db_size_mb'] ?? 0, 2); ?> MB
                </div>
            </div>
            
            <div class="card stat-card">
                <div class="stat-label">Latest Upload</div>
                <div class="stat-value" style="font-size: 1.2em;">
                    <?php 
                    if ($stats['latest_photo']) {
                        echo date('M d, H:i', strtotime($stats['latest_photo']));
                    } else {
                        echo 'None';
                    }
                    ?>
                </div>
            </div>
        </div>
        
        <div class="card">
            <h2>📋 Recent Photos</h2>
            <?php if (count($recentPhotos) > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Filename</th>
                            <th>Original Name</th>
                            <th>Size</th>
                            <th>Dimensions</th>
                            <th>Uploaded</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recentPhotos as $photo): ?>
                            <tr>
                                <td><code><?php echo htmlspecialchars($photo['filename']); ?></code></td>
                                <td><?php echo htmlspecialchars($photo['original_name'] ?? '—'); ?></td>
                                <td><?php echo number_format($photo['file_size'] / 1024, 2) . ' KB'; ?></td>
                                <td><?php echo $photo['width'] . 'x' . $photo['height']; ?></td>
                                <td><?php echo date('M d, Y H:i', strtotime($photo['created_at'])); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p style="color: #999; text-align: center; padding: 20px;">No photos found</p>
            <?php endif; ?>
        </div>
        
        <div class="card">
            <div class="maintenance">
                <h3>🧹 Database Maintenance</h3>
                
                <form method="POST" style="margin-bottom: 15px;">
                    <input type="hidden" name="action" value="clear_deleted">
                    <p style="margin-bottom: 10px; color: #666;">Clear all soft-deleted photos from database:</p>
                    <button type="submit" class="btn btn-primary btn-sm" onclick="return confirm('This will permanently remove deleted photos. Continue?')">
                        Clear Deleted Photos
                    </button>
                </form>
                
                <form method="POST">
                    <input type="hidden" name="action" value="cleanup_old">
                    <div class="form-group">
                        <label>Remove soft-deleted photos older than (days):</label>
                        <input type="number" name="days" value="30" min="1" max="365" style="width: 100px;">
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm" onclick="return confirm('This will permanently delete old photos. Continue?')">
                        Cleanup Old Photos
                    </button>
                </form>
                
                <div class="db-info">
                    <strong>Database Info:</strong><br>
                    Host: <?php echo DB_HOST; ?><br>
                    Database: <?php echo DB_NAME; ?><br>
                    Photos Table: <?php echo $stats['total_photos'] ?? 0; ?> rows (<?php echo $stats['total_photos'] > 0 ? number_format(($stats['total_size'] ?? 0) / 1024, 2) . ' KB' : '0 KB'; ?>)<br>
                    Last Updated: <?php echo date('M d, Y H:i:s'); ?>
                </div>
            </div>
        </div>
        
        <footer>
            <p>📸 Photobooth Admin Dashboard | <a href="index.php">Back to App</a></p>
        </footer>
    </div>
</body>
</html>
