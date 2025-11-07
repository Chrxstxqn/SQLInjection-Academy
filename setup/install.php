<?php
/**
 * Database Setup Script
 * Run this file once to initialize the database
 */

require_once '../config/database.php';

// Enable error reporting for setup
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "<!DOCTYPE html>";
echo "<html lang='en'>";
echo "<head>";
echo "<meta charset='UTF-8'>";
echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
echo "<title>Database Setup - SQLInjection Academy</title>";
echo "<link rel='stylesheet' href='../assets/css/style.css'>";
echo "</head>";
echo "<body>";
echo "<div class='container'>";
echo "<div class='dashboard'>";
echo "<h1>🛠️ Database Setup</h1>";

try {
    echo "<p>⏳ Initializing database...</p>";
    
    initDatabase();
    
    echo "<div class='success-message'>";
    echo "<p><strong>✅ Success!</strong> Database setup completed.</p>";
    echo "<ul style='text-align: left; margin: 20px 0;'>";
    echo "<li>✅ Database 'sqli_academy' created</li>";
    echo "<li>✅ Table 'users' created</li>";
    echo "<li>✅ Demo users inserted</li>";
    echo "</ul>";
    echo "</div>";
    
    echo "<h2>🔑 Demo Credentials</h2>";
    echo "<table style='width: 100%; margin: 20px 0; border-collapse: collapse;'>";
    echo "<tr style='background: rgba(52, 152, 219, 0.1);'>";
    echo "<th style='padding: 12px; text-align: left; border-bottom: 2px solid #0f3460;'>Username</th>";
    echo "<th style='padding: 12px; text-align: left; border-bottom: 2px solid #0f3460;'>Password</th>";
    echo "<th style='padding: 12px; text-align: left; border-bottom: 2px solid #0f3460;'>Role</th>";
    echo "</tr>";
    
    $users = [
        ['admin', 'admin123', 'admin'],
        ['john_doe', 'password123', 'user'],
        ['alice', 'alice2024', 'user'],
        ['bob_smith', 'secure456', 'user'],
        ['charlie', 'charlie789', 'moderator']
    ];
    
    foreach ($users as $user) {
        echo "<tr>";
        echo "<td style='padding: 12px; border-bottom: 1px solid #0f3460;'>" . htmlspecialchars($user[0]) . "</td>";
        echo "<td style='padding: 12px; border-bottom: 1px solid #0f3460;'><code>" . htmlspecialchars($user[1]) . "</code></td>";
        echo "<td style='padding: 12px; border-bottom: 1px solid #0f3460;'>" . htmlspecialchars($user[2]) . "</td>";
        echo "</tr>";
    }
    
    echo "</table>";
    
    echo "<div class='actions'>";
    echo "<a href='../vulnerable/login.php' class='btn btn-primary'>🔓 Try Vulnerable Login</a>";
    echo "<a href='../secure/login.php' class='btn btn-secondary'>🔒 Try Secure Login</a>";
    echo "<a href='../index.html' class='btn btn-secondary'>🏠 Back to Home</a>";
    echo "</div>";
    
} catch (Exception $e) {
    echo "<div class='alert alert-error'>";
    echo "<p><strong>❌ Error:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<p style='margin-top: 10px;'><strong>Troubleshooting:</strong></p>";
    echo "<ul style='text-align: left; margin: 10px 0;'>";
    echo "<li>Make sure MySQL/MariaDB is running</li>";
    echo "<li>Check database credentials in config/database.php</li>";
    echo "<li>Ensure the database user has CREATE privileges</li>";
    echo "</ul>";
    echo "</div>";
}

echo "</div>";
echo "</div>";
echo "</body>";
echo "</html>";
?>