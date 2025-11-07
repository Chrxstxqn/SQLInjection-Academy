<?php
/**
 * Database Configuration
 * SQLInjection Academy - Educational Purpose Only
 */

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'sqli_academy');

/**
 * Create database connection
 * @return mysqli|false
 */
function getConnection() {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    return $conn;
}

/**
 * Initialize database and create tables
 */
function initDatabase() {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS);
    
    // Create database if not exists
    $sql = "CREATE DATABASE IF NOT EXISTS sqli_academy";
    $conn->query($sql);
    
    $conn->select_db('sqli_academy');
    
    // Create users table
    $sql = "CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        email VARCHAR(100),
        role VARCHAR(20) DEFAULT 'user',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    $conn->query($sql);
    
    // Insert demo users
    $users = [
        ['admin', 'admin123', 'admin@sqli-academy.local', 'admin'],
        ['john_doe', 'password123', 'john@example.com', 'user'],
        ['alice', 'alice2024', 'alice@example.com', 'user'],
        ['bob_smith', 'secure456', 'bob@example.com', 'user'],
        ['charlie', 'charlie789', 'charlie@example.com', 'moderator']
    ];
    
    foreach ($users as $user) {
        $stmt = $conn->prepare("INSERT IGNORE INTO users (username, password, email, role) VALUES (?, ?, ?, ?)");
        $hashedPassword = password_hash($user[1], PASSWORD_DEFAULT);
        $stmt->bind_param("ssss", $user[0], $hashedPassword, $user[2], $user[3]);
        $stmt->execute();
    }
    
    $conn->close();
}
?>