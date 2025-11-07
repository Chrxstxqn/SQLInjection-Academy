<?php
/**
 * Environment Check Script
 * Verify server configuration and requirements
 */

echo "<!DOCTYPE html>";
echo "<html lang='en'>";
echo "<head>";
echo "<meta charset='UTF-8'>";
echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
echo "<title>Environment Check - SQLInjection Academy</title>";
echo "<link rel='stylesheet' href='../assets/css/style.css'>";
echo "</head>";
echo "<body>";
echo "<div class='container'>";
echo "<div class='dashboard'>";
echo "<h1>🔍 Environment Check</h1>";

function checkRequirement($name, $check, $recommendation = '') {
    echo "<tr>";
    echo "<td style='padding: 12px; border-bottom: 1px solid #0f3460;'>" . $name . "</td>";
    
    if ($check) {
        echo "<td style='padding: 12px; border-bottom: 1px solid #0f3460; color: #51cf66;'>✅ OK</td>";
    } else {
        echo "<td style='padding: 12px; border-bottom: 1px solid #0f3460; color: #ff6b6b;'>❌ Failed</td>";
    }
    
    echo "<td style='padding: 12px; border-bottom: 1px solid #0f3460; color: #aaa; font-size: 14px;'>" . $recommendation . "</td>";
    echo "</tr>";
}

echo "<table style='width: 100%; margin: 20px 0;'>";
echo "<tr style='background: rgba(52, 152, 219, 0.1);'>";
echo "<th style='padding: 12px; text-align: left; border-bottom: 2px solid #0f3460;'>Requirement</th>";
echo "<th style='padding: 12px; text-align: left; border-bottom: 2px solid #0f3460;'>Status</th>";
echo "<th style='padding: 12px; text-align: left; border-bottom: 2px solid #0f3460;'>Notes</th>";
echo "</tr>";

// PHP Version
checkRequirement(
    'PHP Version >= 7.4',
    version_compare(PHP_VERSION, '7.4.0', '>='),
    'Current: ' . PHP_VERSION
);

// MySQLi Extension
checkRequirement(
    'MySQLi Extension',
    extension_loaded('mysqli'),
    'Required for database operations'
);

// PDO Extension
checkRequirement(
    'PDO Extension',
    extension_loaded('pdo'),
    'Alternative to MySQLi'
);

// Session Support
checkRequirement(
    'Session Support',
    function_exists('session_start'),
    'Required for user authentication'
);

// JSON Support
checkRequirement(
    'JSON Support',
    function_exists('json_encode'),
    'Required for data processing'
);

// File Permissions
$configWritable = is_writable('../config');
checkRequirement(
    'Config Directory Writable',
    $configWritable,
    $configWritable ? 'Good' : 'May need write permissions for logs'
);

echo "</table>";

echo "<h2>📦 Server Information</h2>";
echo "<table style='width: 100%; margin: 20px 0;'>";
echo "<tr><th style='padding: 12px; text-align: left; width: 30%;'>PHP Version</th><td style='padding: 12px;'>" . PHP_VERSION . "</td></tr>";
echo "<tr><th style='padding: 12px; text-align: left;'>Server Software</th><td style='padding: 12px;'>" . $_SERVER['SERVER_SOFTWARE'] . "</td></tr>";
echo "<tr><th style='padding: 12px; text-align: left;'>Document Root</th><td style='padding: 12px;'>" . $_SERVER['DOCUMENT_ROOT'] . "</td></tr>";
echo "<tr><th style='padding: 12px; text-align: left;'>PHP Extensions</th><td style='padding: 12px;'>" . implode(', ', get_loaded_extensions()) . "</td></tr>";
echo "</table>";

echo "<div class='actions'>";
echo "<a href='install.php' class='btn btn-primary'>🛠️ Run Database Setup</a>";
echo "<a href='../index.html' class='btn btn-secondary'>🏠 Back to Home</a>";
echo "</div>";

echo "</div>";
echo "</div>";
echo "</body>";
echo "</html>";
?>