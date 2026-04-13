# Hostinger Deployment Guide

## Step 1: Hostinger Database Setup

1. **Login to Hostinger hPanel**
2. **Go to MySQL Databases**
3. **Create New Database:**
   - Database Name: `u123456789_employee` (example)
   - Username: `u123456789_user` (example)
   - Password: Create strong password

## Step 2: Update Database Configuration

**Edit `config/database.php` with your Hostinger details:**

```php
private $host = "localhost";
private $db_name = "u123456789_employee"; // Your actual database name
private $username = "u123456789_user";    // Your actual username
private $password = "YourActualPassword"; // Your actual password
```

## Step 3: Upload Files

1. **Zip all project files**
2. **Upload to Hostinger File Manager**
3. **Extract in public_html folder**
4. **Set folder permissions:**
   - `uploads/` folder: 755 or 777
   - `uploads/profiles/`: 755 or 777
   - `uploads/attendance/`: 755 or 777

## Step 4: Access Your Site

- **URL:** `https://yourdomain.com/`
- **Admin Login:**
  - Employee ID: `ADMIN001`
  - Password: `password`
  - Role: Admin

## Important Notes:

1. **Database auto-creates** on first page load
2. **Change admin password** after first login
3. **Enable HTTPS** in production
4. **Camera requires HTTPS** for live photos

## Hostinger Specific Settings:

- **PHP Version:** 7.4 or higher
- **MySQL Version:** 5.7 or higher
- **File Upload Limit:** Check in hPanel
- **Memory Limit:** 128MB minimum

## Troubleshooting:

- **Connection Error:** Check database credentials
- **Permission Error:** Set folder permissions to 755/777
- **Camera Not Working:** Ensure HTTPS is enabled