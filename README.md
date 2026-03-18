# 📸 Online Photobooth

A fully functional, web-based photobooth application built with PHP, CSS, and JavaScript. Features MySQL database integration for persistent storage and management. Capture, download, and manage your photos directly from your browser!

## Features

✨ **Core Features:**
- 📷 Real-time camera access using WebRTC
- 🖼️ High-quality photo capture
- ⬇️ Download captured photos
- 🔄 Retake functionality
- 📱 Responsive design (mobile-friendly)
- 🎨 Beautiful gradient UI

✅ **Database Features:**
- 💾 MySQL integration for persistent storage
- 📊 Photo metadata tracking (dimensions, file size, upload time)
- 🗑️ Soft-delete functionality (recover deleted photos)
- 📈 Database statistics and analytics
- 🧹 Automated maintenance tasks
- 🔍 Advanced photo queries and pagination

✅ **Gallery Features:**
- Auto-save photos to database
- View all captured photos with metadata
- Download photos from gallery
- Delete unwanted photos
- Grid layout for easy browsing
- Soft-delete recovery options

🔒 **Security:**
- Server-side file validation
- MIME type checking
- Malicious file prevention
- Directory traversal protection
- Disabled PHP execution in uploads folder
- SQL injection prevention with prepared statements
- User IP logging for audit trail

## Requirements

- PHP 7.0 or higher
- Web server (Apache, Nginx, etc.)
- Modern web browser with webcam access
- GD library (optional, for image resizing)

## Installation

1. **Place files in web root:**
   - Copy all files to your web server directory (e.g., `/var/www/html/photobooth/` or `C:\xampp\htdocs\photobooth\`)

2. **Set permissions:**
   ```bash
   chmod 755 uploads/
   ```

3. **Configure database (if not localhost/root):**
   - Edit `db_config.php`
   - Update `DB_HOST`, `DB_USER`, `DB_PASS`, `DB_NAME`

4. **Initialize database:**
   - Open `http://localhost/photobooth/db_setup.php` in your browser
   - This will auto-create the database and tables
   - You should see "Setup Successful" message

5. **Verify installation:**
   - Access `http://localhost/photobooth/`
   - Start using the photobooth
   - Check admin dashboard at `http://localhost/photobooth/admin.php`

## How to Use

1. **Start Camera:**
   - Click "Start Camera" button
   - Allow browser to access your webcam

2. **Capture Photo:**
   - Click "Capture Photo" button
   - Your photo will appear in the preview area

3. **Download or Retake:**
   - Click "Download" to save the photo to your device
   - Click "Retake" to capture another photo
   - Downloaded photos are automatically added to the gallery

4. **Manage Gallery:**
   - View all your photos in the gallery section
   - Hover over photos to download or delete
   - Photos are stored on the server

5. **Stop Camera:**
   - Click "Stop Camera" when finished

## File Structure

```
photobooth/
├── index.php           # Main HTML/Application page
├── api.php             # Backend API for photo operations (MySQL-integrated)
├── db_config.php       # Database connection configuration
├── db_setup.php        # Database initialization script
├── admin.php           # Admin dashboard with statistics
├── config.php          # Application configuration
├── .htaccess           # Security configuration
├── css/
│   └── style.css       # Styling and responsive design
├── js/
│   └── script.js       # Camera and gallery functionality
├── uploads/            # Photo storage directory
└── README.md           # This file
```

## Database Schema

### Photos Table
```sql
CREATE TABLE photos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    filename VARCHAR(255) UNIQUE,
    original_name VARCHAR(255),
    file_size INT,
    width INT,
    height INT,
    mime_type VARCHAR(50),
    upload_path VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL,
    is_deleted BOOLEAN DEFAULT FALSE,
    user_ip VARCHAR(45)
);
```

### Settings Table
```sql
CREATE TABLE settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    setting_key VARCHAR(100) UNIQUE,
    setting_value LONGTEXT,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

## Admin Dashboard

Access the admin dashboard at: `http://localhost/photobooth/admin.php`

**Features:**
- 📊 View total photos and storage statistics
- 📈 Monitor database size
- 📋 See recent uploads with metadata
- 🧹 Maintenance tools:
  - Clear soft-deleted photos
  - Clean up old photos automatically
  - View database information

## API Endpoints (MySQL-Integrated)

### Save Photo
- **Endpoint:** `api.php?action=save`
- **Method:** POST
- **Data:** FormData with 'photo' file
- **Response:** JSON with id, filename, or error
- **Stores:** Photo file + metadata in database

### List Photos
- **Endpoint:** `api.php?action=list&limit=50&offset=0`
- **Method:** GET
- **Parameters:**
  - `limit` - Photos per page (default: 50, max: 100)
  - `offset` - Pagination offset (default: 0)
- **Response:** JSON array with photo objects including metadata
- **Queries:** MySQL database only

### Delete Photo
- **Endpoint:** `api.php?action=delete&filename=FILENAME`
- **Method:** GET
- **Response:** JSON success/error message
- **Action:** Soft-deletes (marks as deleted in database)

## Browser Compatibility

- ✅ Chrome/Edge (90+)
- ✅ Firefox (88+)
- ✅ Safari (14+)
- ✅ Mobile browsers (iOS Safari 14.5+, Chrome Mobile)

## Troubleshooting

**Camera won't start:**
- Ensure you allowed camera permissions in your browser
- Check if your device has a camera
- Try a different browser

**Photos not saving:**
- Verify `uploads/` directory has write permissions
- Check PHP error logs
- Ensure file upload is enabled in php.ini
- **Check database connection:** Verify credentials in `db_config.php`

**Database connection fails:**
- Ensure MySQL is running
- Verify database credentials in `db_config.php`
- Check if user has proper permissions
- Run `db_setup.php` to create database and tables
- Check error message on `db_setup.php` for detailed info

**Admin dashboard shows no data:**
- Verify MySQL is running
- Check database credentials
- Ensure photos table was created (run `db_setup.php`)
- Check PHP error logs

**Page not loading:**
- Verify the web server is running
- Check if PHP is installed and enabled
- Verify MySQL is running (for database features)
- Review error logs

## Performance Tips

- The application automatically resizes large images (if GD is available)
- Photos are compressed to 90% JPEG quality
- Clear old photos regularly to save server space
- Consider adding a maximum file size limit

## Security Notes

- The application validates all uploaded files
- File type is verified using MIME type checking
- Directory traversal attacks are prevented
- PHP execution is disabled in the uploads folder
- Consider adding authentication for production use

## Future Enhancements

- 👤 User authentication and profiles
- 📸 Photo filters and effects
- 🎥 Video recording capability
- 🔗 Photo sharing options with permissions
- 📱 Multiple camera selection
- ☁️ Cloud storage integration (AWS S3, Google Drive)
- 🔐 Two-factor authentication
- 📝 Photo annotations and comments
- 🏷️ Photo tagging system
- 📊 Advanced analytics dashboard
- 📧 Email notifications
- 🔄 Photo version history
- 🎨 Custom branding options
- 🌍 Multi-language support

## MySQL Features Added

✨ **Database Integration:**
- Persistent photo metadata storage
- User IP logging for security audits
- Soft-delete functionality (safe recovery)
- Advanced query capabilities
- Database statistics tracking
- Automatic backup recommendations
- Photo size and dimension tracking
- Upload timestamp tracking

## License

This photobooth application is provided as-is for educational and personal use.

## Support

For issues or questions:
- Check the browser console (F12) for JavaScript errors
- Review PHP error logs for backend issues
- Check MySQL server status and logs
- Run `db_setup.php` to verify database setup
- Review credentials in `db_config.php`

---

**Enjoy capturing memories! 📸**
