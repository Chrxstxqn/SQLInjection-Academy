<?php
/**
 * VULNERABLE LOGIN PAGE
 * ⚠️ WARNING: This page is intentionally vulnerable for educational purposes
 * DO NOT use this code in production environments!
 */

session_start();
require_once '../config/database.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    // VULNERABLE: SQL Injection vulnerability
    $conn = getConnection();
    $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = $conn->query($query);
    
    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        $success = "Login successful! Welcome " . htmlspecialchars($user['username']);
        header('refresh:2;url=dashboard.php');
    } else {
        $error = "Invalid credentials!";
    }
    
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vulnerable Login - SQLInjection Academy</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="login-page">
    <div class="container">
        <div class="login-box vulnerable">
            <div class="logo">
                <img src="../assets/images/logo.png" alt="SQLInjection Academy" onerror="this.style.display='none'">
                <h1>🔓 Vulnerable Login</h1>
            </div>
            <div class="warning-banner">
                ⚠️ This login page is intentionally vulnerable to SQL injection attacks
            </div>
            
            <?php if ($error): ?>
                <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            
            <?php if ($success): ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
            <?php endif; ?>
            
            <form method="POST" action="">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary">Login</button>
            </form>
            
            <div class="hints">
                <h3>💡 Testing Hints</h3>
                <ul>
                    <li>Try: <code>admin' --</code></li>
                    <li>Try: <code>' OR '1'='1</code></li>
                    <li>Try: <code>admin' OR '1'='1' --</code></li>
                </ul>
            </div>
            
            <div class="links">
                <a href="../secure/login.php">Try Secure Version</a>
                <a href="../index.html">Back to Home</a>
            </div>
        </div>
    </div>
</body>
</html>