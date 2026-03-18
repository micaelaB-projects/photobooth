# Quick Start Guide - MySQL Database Setup

## Prerequisites

- PHP 7.0 or higher with MySQLi extension
- MySQL Server 5.7+ or MariaDB
- Web server (Apache, Nginx)
- Modern web browser

## Step 1: Configure Database Connection

Edit `db_config.php` and set your database credentials:

```php
define('DB_HOST', 'localhost');      // MySQL host
define('DB_USER', 'root');           // MySQL username
define('DB_PASS', '');               // MySQL password
define('DB_NAME', 'photobooth');     // Database name
define('DB_PORT', 3306);             // MySQL port
```

**Common configurations:**

**XAMPP (Windows):**
```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
```

**Linux/Apache:**
```php
define('DB_HOST', 'localhost');
define('DB_USER', 'photobooth_user');
define('DB_PASS', 'your_password');
```

**Docker/Remote:**
```php
define('DB_HOST', '172.17.0.1');  // Docker host
define('DB_USER', 'app_user');
define('DB_PASS', 'secure_password');
```

## Step 2: Create Database User (MySQL)

**If using a dedicated user instead of root:**

```sql
-- Login to MySQL
mysql -u root -p

-- Create database and user
CREATE DATABASE photobooth CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'photobooth'@'localhost' IDENTIFIED BY 'your_password';

-- Grant permissions
GRANT ALL PRIVILEGES ON photobooth.* TO 'photobooth'@'localhost';
FLUSH PRIVILEGES;

-- Verify
SHOW GRANTS FOR 'photobooth'@'localhost';
```

## Step 3: Run Database Setup

1. Open your browser and navigate to:
   ```
   http://localhost/photobooth/db_setup.php
   ```

2. You should see:
   - ✓ Database created successfully
   - ✓ Photos table created successfully
   - ✓ Settings table created successfully
   - Setup Complete!

3. If you see errors:
   - Check MySQL is running
   - Verify credentials in `db_config.php`
   - Check file permissions
   - Review PHP error logs

## Step 4: Verify Installation

1. **Access main app:**
   ```
   http://localhost/photobooth/
   ```

2. **Check admin dashboard:**
   ```
   http://localhost/photobooth/admin.php
   ```

3. **Test a photo capture:**
   - Click "Start Camera"
   - Click "Capture Photo"
   - Click "Download"
   - Verify it appears in uploads folder and admin dashboard

## Database Tables

The setup automatically creates:

### `photos` table
- Stores photo metadata
- Fields: id, filename, width, height, size, created_at, is_deleted, etc.
- Soft-delete enabled (is_deleted, deleted_at)

### `settings` table
- Stores application configuration
- Can be used for feature flags, defaults, etc.

## Troubleshooting

### "Connection failed" error

**Check MySQL is running:**
```bash
# Windows (check services)
net start MySQL80  # or your version

# Linux
sudo service mysql status
sudo service mysql start

# Mac
brew services start mysql
```

**Verify port:**
```sql
SHOW VARIABLES LIKE 'port';
```

### "Access denied for user"

```bash
# Reset MySQL root password (Windows CMD)
mysqld --skip-grant-tables
mysql -u root
FLUSH PRIVILEGES;
ALTER USER 'root'@'localhost' IDENTIFIED BY 'newpassword';
```

### "Database doesn't exist"

- Make sure `db_setup.php` ran successfully
- Check write permissions on the MySQL data directory
- Try creating database manually:
  ```sql
  CREATE DATABASE photobooth CHARACTER SET utf8mb4;
  ```

### PHP Can't Connect

Install MySQLi extension:

**Ubuntu/Debian:**
```bash
sudo apt-get install php-mysql
sudo apt-get install php-mysqli
sudo service php7.4-fpm restart
```

**Windows (XAMPP):**
- Edit `php.ini`
- Uncomment: `;extension=mysqli`
- Restart Apache

## Advanced Configuration

### Enable Image Resizing (Optional)

Install GD library:

**Ubuntu/Debian:**
```bash
sudo apt-get install php-gd
sudo service php7.4-fpm restart
```

**Windows (XAMPP):**
- Edit `php.ini`
- Uncomment: `;extension=gd`
- Restart Apache

### Increase Upload Limits

Edit `php.ini`:
```ini
upload_max_filesize = 100M
post_max_size = 100M
max_execution_time = 300
```

### Regular Backups

**MySQL backup:**
```bash
mysqldump -u root -p photobooth > backup.sql
```

**Restore backup:**
```bash
mysql -u root -p photobooth < backup.sql
```

### Enable Query Logging (Debug)

Add to `db_config.php`:
```php
error_log("Query: " . $query, 3, "logs/queries.log");
```

## Performance Tips

1. **Indexes:** Already set on `created_at` and `is_deleted` fields
2. **Pagination:** API supports limit/offset for large datasets
3. **Compression:** Images are automatically optimized
4. **Cleanup:** Use admin panel to remove old deleted photos
5. **Soft-delete:** Queries automatically exclude deleted photos

## Security Best Practices

✅ **Already Implemented:**
- Prepared statements (SQL injection prevention)
- MIME type validation
- File upload verification
- Directory traversal prevention

✅ **Recommended Additional:**
- Use strong MySQL password
- Don't use 'root' user for production
- Restrict MySQL to localhost if possible
- Regular database backups
- Monitor error logs for suspicious activity
- Consider adding user authentication
- Set up HTTPS/SSL for production

## Next Steps

1. ✅ Start capturing photos
2. 📊 Monitor stats in admin dashboard
3. 🧹 Clean up old photos regularly
4. 🔐 Add authentication for multi-user setup
5. ☁️ Consider cloud storage integration

## Support Resources

- MySQL Documentation: https://dev.mysql.com/doc/
- PHP MySQLi: https://www.php.net/manual/en/book.mysqli.php
- XAMPP Docs: https://www.apachefriends.org/
- Apache Docs: https://httpd.apache.org/docs/

---

Happy photobooth! 📸
