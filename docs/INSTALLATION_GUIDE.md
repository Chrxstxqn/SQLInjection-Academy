# 🛠️ Complete Installation Guide

## Table of Contents
1. [System Requirements](#system-requirements)
2. [Windows Installation](#windows-installation)
3. [macOS Installation](#macos-installation)
4. [Linux Installation](#linux-installation)
5. [Docker Installation](#docker-installation)
6. [Troubleshooting](#troubleshooting)
7. [Post-Installation](#post-installation)

---

## System Requirements

### Minimum Requirements
- **PHP:** 7.4 or higher
- **MySQL:** 8.0 or MariaDB 10.3+
- **RAM:** 2GB
- **Disk Space:** 100MB
- **Web Browser:** Modern browser (Chrome, Firefox, Edge, Safari)

### Recommended
- **PHP:** 8.1+
- **MySQL:** 8.0+
- **RAM:** 4GB+
- **Text Editor:** VS Code, Sublime Text, or PHPStorm

---

## Windows Installation

### Option 1: XAMPP (Recommended for Beginners)

#### Step 1: Install XAMPP
1. Download XAMPP from [https://www.apachefriends.org](https://www.apachefriends.org)
2. Run the installer
3. Select components:
   - ☑️ Apache
   - ☑️ MySQL
   - ☑️ PHP
   - ☑️ phpMyAdmin
4. Install to `C:\xampp`

#### Step 2: Start Services
1. Open XAMPP Control Panel
2. Start Apache
3. Start MySQL
4. Verify both show green "Running" status

#### Step 3: Clone Repository
```bash
# Open Command Prompt or PowerShell
cd C:\xampp\htdocs
git clone https://github.com/Chrxstxqn/SQLInjection-Academy.git
cd SQLInjection-Academy
```

Or download ZIP:
1. Download from GitHub
2. Extract to `C:\xampp\htdocs\SQLInjection-Academy`

#### Step 4: Configure Database
1. Edit `config/database.php`:
```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');  // Leave empty for XAMPP default
define('DB_NAME', 'sqli_academy');
```

#### Step 5: Initialize Database

**Option A: Web Setup (Easiest)**
```
http://localhost/SQLInjection-Academy/setup/install.php
```

**Option B: phpMyAdmin**
1. Go to http://localhost/phpmyadmin
2. Click "Import"
3. Choose `setup/database.sql`
4. Click "Go"

**Option C: Command Line**
```bash
cd C:\xampp\mysql\bin
mysql.exe -u root < C:\xampp\htdocs\SQLInjection-Academy\setup\database.sql
```

#### Step 6: Access Application
```
http://localhost/SQLInjection-Academy/
```

### Option 2: WampServer

1. Download WAMP from [https://www.wampserver.com](https://www.wampserver.com)
2. Install to `C:\wamp64`
3. Clone repository to `C:\wamp64\www\SQLInjection-Academy`
4. Follow steps 4-6 from XAMPP guide
5. Access: `http://localhost/SQLInjection-Academy/`

---

## macOS Installation

### Option 1: MAMP (Easiest)

#### Step 1: Install MAMP
```bash
# Download from https://www.mamp.info
# Or use Homebrew:
brew install --cask mamp
```

#### Step 2: Start MAMP
1. Open MAMP application
2. Click "Start Servers"
3. Verify Apache and MySQL are running

#### Step 3: Clone Repository
```bash
cd /Applications/MAMP/htdocs
git clone https://github.com/Chrxstxqn/SQLInjection-Academy.git
cd SQLInjection-Academy
```

#### Step 4: Configure Database
```php
// config/database.php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', 'root');  // MAMP default
define('DB_NAME', 'sqli_academy');
```

#### Step 5: Setup Database
```bash
# Terminal
/Applications/MAMP/Library/bin/mysql -u root -proot < setup/database.sql
```

Or visit: `http://localhost:8888/SQLInjection-Academy/setup/install.php`

### Option 2: Homebrew (Advanced)

```bash
# Install PHP and MySQL
brew install php@8.1
brew install mysql

# Start services
brew services start php
brew services start mysql

# Configure MySQL
mysql_secure_installation

# Clone repository
cd ~/Sites
git clone https://github.com/Chrxstxqn/SQLInjection-Academy.git
cd SQLInjection-Academy

# Configure database credentials
vim config/database.php

# Import database
mysql -u root -p < setup/database.sql

# Start PHP built-in server
php -S localhost:8000

# Access: http://localhost:8000
```

---

## Linux Installation

### Ubuntu/Debian

#### Step 1: Install LAMP Stack
```bash
# Update package list
sudo apt update

# Install Apache
sudo apt install apache2

# Install MySQL
sudo apt install mysql-server

# Install PHP
sudo apt install php libapache2-mod-php php-mysql

# Install additional PHP extensions
sudo apt install php-mysqli php-pdo php-json

# Start services
sudo systemctl start apache2
sudo systemctl start mysql

# Enable services on boot
sudo systemctl enable apache2
sudo systemctl enable mysql
```

#### Step 2: Secure MySQL
```bash
sudo mysql_secure_installation
```

#### Step 3: Clone Repository
```bash
# Navigate to web root
cd /var/www/html

# Clone repository (requires sudo)
sudo git clone https://github.com/Chrxstxqn/SQLInjection-Academy.git

# Set permissions
sudo chown -R www-data:www-data SQLInjection-Academy
sudo chmod -R 755 SQLInjection-Academy
```

#### Step 4: Configure Database
```bash
# Edit database config
sudo nano /var/www/html/SQLInjection-Academy/config/database.php
```

```php
define('DB_HOST', 'localhost');
define('DB_USER', 'sqli_user');
define('DB_PASS', 'your_secure_password');
define('DB_NAME', 'sqli_academy');
```

#### Step 5: Create MySQL User
```bash
sudo mysql
```

```sql
CREATE USER 'sqli_user'@'localhost' IDENTIFIED BY 'your_secure_password';
GRANT ALL PRIVILEGES ON sqli_academy.* TO 'sqli_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

#### Step 6: Import Database
```bash
mysql -u sqli_user -p sqli_academy < /var/www/html/SQLInjection-Academy/setup/database.sql
```

#### Step 7: Configure Apache
```bash
# Enable mod_rewrite
sudo a2enmod rewrite

# Restart Apache
sudo systemctl restart apache2
```

#### Step 8: Access Application
```
http://localhost/SQLInjection-Academy/
```

### Fedora/CentOS/RHEL

```bash
# Install packages
sudo dnf install httpd mariadb-server php php-mysqlnd

# Start services
sudo systemctl start httpd
sudo systemctl start mariadb

# Enable on boot
sudo systemctl enable httpd
sudo systemctl enable mariadb

# Follow Ubuntu steps 2-8
```

---

## Docker Installation

### Using Docker Compose

#### Step 1: Create docker-compose.yml
```yaml
version: '3.8'

services:
  web:
    image: php:8.1-apache
    ports:
      - "8080:80"
    volumes:
      - ./:/var/www/html
    depends_on:
      - db
    environment:
      - DB_HOST=db
      - DB_USER=root
      - DB_PASS=rootpassword
      - DB_NAME=sqli_academy

  db:
    image: mysql:8.0
    environment:
      - MYSQL_ROOT_PASSWORD=rootpassword
      - MYSQL_DATABASE=sqli_academy
    volumes:
      - mysql_data:/var/lib/mysql
      - ./setup/database.sql:/docker-entrypoint-initdb.d/init.sql

  phpmyadmin:
    image: phpmyadmin:latest
    ports:
      - "8081:80"
    environment:
      - PMA_HOST=db
      - PMA_USER=root
      - PMA_PASSWORD=rootpassword

volumes:
  mysql_data:
```

#### Step 2: Start Containers
```bash
docker-compose up -d
```

#### Step 3: Access Application
```
Application: http://localhost:8080
phpMyAdmin: http://localhost:8081
```

---

## Troubleshooting

### Common Issues

#### Issue 1: "Connection refused" Error
**Cause:** MySQL not running

**Solution:**
```bash
# Windows (XAMPP)
# Open XAMPP Control Panel, start MySQL

# Linux
sudo systemctl start mysql

# macOS (MAMP)
# Open MAMP, click "Start Servers"
```

#### Issue 2: "Access denied for user"
**Cause:** Wrong database credentials

**Solution:**
1. Check `config/database.php`
2. Verify MySQL username/password
3. Reset MySQL password if needed

#### Issue 3: "Table 'sqli_academy.users' doesn't exist"
**Cause:** Database not initialized

**Solution:**
```bash
# Re-run database setup
php setup/install.php

# Or import SQL manually
mysql -u root -p sqli_academy < setup/database.sql
```

#### Issue 4: "404 Not Found"
**Cause:** Wrong URL or web root

**Solution:**
```
# Verify URL format
✅ http://localhost/SQLInjection-Academy/
❌ http://localhost/SQLInjection-Academy
❌ http://localhost:80/SQLInjection-Academy/
```

#### Issue 5: PHP errors visible
**Cause:** display_errors enabled

**Solution (for production):**
```php
// php.ini
display_errors = Off
log_errors = On
error_log = /path/to/error.log
```

### Verification Checklist

```bash
# Run environment check
http://localhost/SQLInjection-Academy/setup/check.php
```

Verify:
- [ ] PHP version >= 7.4
- [ ] MySQL running
- [ ] mysqli extension loaded
- [ ] Database created
- [ ] Tables created
- [ ] Sample data inserted
- [ ] Login pages accessible

---

## Post-Installation

### Security Recommendations

1. **Change default MySQL password**
```bash
mysql -u root -p
ALTER USER 'root'@'localhost' IDENTIFIED BY 'new_strong_password';
```

2. **Update database config**
```php
define('DB_PASS', 'new_strong_password');
```

3. **Remove setup files (production only)**
```bash
rm -rf setup/
```

4. **Configure firewall**
```bash
# Linux: Allow only localhost
sudo ufw allow from 127.0.0.1 to any port 3306
```

### Testing Installation

1. **Test vulnerable login:**
```
URL: http://localhost/SQLInjection-Academy/vulnerable/login.php
Username: admin' --
Password: anything
Result: Should bypass authentication
```

2. **Test secure login:**
```
URL: http://localhost/SQLInjection-Academy/secure/login.php
Username: admin
Password: admin123
Result: Should login successfully

Username: admin' --
Password: anything
Result: Should fail (secure)
```

### Next Steps

1. Read [README.md](../README.md)
2. Start with [Chapter 1](../course/01-introduction.md)
3. Complete [Lab 1](../labs/lab1-authentication-bypass.md)
4. Explore the course materials

---

## Getting Help

- 🐛 [Report Issues](https://github.com/Chrxstxqn/SQLInjection-Academy/issues)
- 💬 [Discussions](https://github.com/Chrxstxqn/SQLInjection-Academy/discussions)
- 📚 [Documentation](../README.md)

---

**Happy Learning! 🎓**