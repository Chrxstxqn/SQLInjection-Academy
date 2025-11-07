-- SQLInjection Academy Database Setup
-- This script creates the database, tables, and sample data
-- Run this if you prefer manual SQL installation over PHP script

-- Create database
CREATE DATABASE IF NOT EXISTS sqli_academy
DEFAULT CHARACTER SET utf8mb4
DEFAULT COLLATE utf8mb4_unicode_ci;

-- Use the database
USE sqli_academy;

-- Create users table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL,
    role VARCHAR(20) DEFAULT 'user',
    status VARCHAR(20) DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    last_login TIMESTAMP NULL,
    login_attempts INT DEFAULT 0,
    
    INDEX idx_username (username),
    INDEX idx_email (email),
    INDEX idx_role (role),
    INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert demo users with hashed passwords
-- Note: These passwords are hashed using PHP's password_hash() function
-- For testing, use the plain passwords listed in comments

INSERT INTO users (username, password, email, role) VALUES
-- Username: admin, Password: admin123
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin@sqli-academy.local', 'admin'),

-- Username: john_doe, Password: password123
('john_doe', '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', 'john@example.com', 'user'),

-- Username: alice, Password: alice2024
('alice', '$2y$10$zYGmE6.9vPwZzEiX4WXkSujR8Y9mxCUqC9uj5xRcqY4dWH7jXvVLa', 'alice@example.com', 'user'),

-- Username: bob_smith, Password: secure456
('bob_smith', '$2y$10$j7tDWHyHC5p6IXqQKdF4DOE4CJqP8xz/p0xLXmwBCE5WG7pKNT9X6', 'bob@example.com', 'user'),

-- Username: charlie, Password: charlie789
('charlie', '$2y$10$cOqLfWK8tHjYTBVrLLzEDe5RjYmJRuHt1QrGVKk9vVGxNdDhKLZxC', 'charlie@example.com', 'moderator');

-- Create additional table for practicing UNION attacks
CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    category VARCHAR(50),
    stock INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    INDEX idx_name (name),
    INDEX idx_category (category)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert sample products
INSERT INTO products (name, description, price, category, stock) VALUES
('Laptop Pro', 'High-performance laptop for developers', 1299.99, 'Electronics', 15),
('Wireless Mouse', 'Ergonomic wireless mouse', 29.99, 'Electronics', 50),
('Mechanical Keyboard', 'RGB mechanical keyboard', 89.99, 'Electronics', 30),
('USB-C Hub', '7-in-1 USB-C hub with HDMI', 49.99, 'Accessories', 40),
('Laptop Stand', 'Adjustable aluminum laptop stand', 39.99, 'Accessories', 25),
('Webcam HD', '1080p HD webcam', 79.99, 'Electronics', 20),
('Headphones', 'Noise-cancelling wireless headphones', 199.99, 'Audio', 12),
('Microphone', 'USB condenser microphone', 89.99, 'Audio', 18),
('Monitor 27"', '27-inch 4K monitor', 399.99, 'Electronics', 8),
('Desk Lamp', 'LED desk lamp with USB charging', 34.99, 'Accessories', 35);

-- Create logs table for tracking (optional)
CREATE TABLE IF NOT EXISTS access_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    action VARCHAR(50),
    ip_address VARCHAR(45),
    user_agent TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    INDEX idx_user_id (user_id),
    INDEX idx_action (action),
    INDEX idx_created_at (created_at),
    
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create sessions table (optional, for session management)
CREATE TABLE IF NOT EXISTS sessions (
    id VARCHAR(128) PRIMARY KEY,
    user_id INT,
    data TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    expires_at TIMESTAMP NULL,
    
    INDEX idx_user_id (user_id),
    INDEX idx_expires_at (expires_at),
    
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Display success message
SELECT 'Database setup completed successfully!' AS message;

-- Display demo credentials
SELECT 
    'Demo Credentials' AS info,
    username,
    CASE username
        WHEN 'admin' THEN 'admin123'
        WHEN 'john_doe' THEN 'password123'
        WHEN 'alice' THEN 'alice2024'
        WHEN 'bob_smith' THEN 'secure456'
        WHEN 'charlie' THEN 'charlie789'
    END AS password,
    role
FROM users
ORDER BY 
    CASE role
        WHEN 'admin' THEN 1
        WHEN 'moderator' THEN 2
        WHEN 'user' THEN 3
    END,
    username;