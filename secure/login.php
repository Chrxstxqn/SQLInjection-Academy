<?php
/**
 * SECURE LOGIN PAGE
 * ✅ This page demonstrates secure coding practices
 * Safe to use as reference for production code
 */

session_start();
require_once '../config/database.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    // SECURE: Using prepared statements
    $conn = getConnection();
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // Verify password using password_verify
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            $success = "Login successful! Welcome " . htmlspecialchars($user['username']);
            header('refresh:2;url=dashboard.php');
        } else {
            $error = "Invalid credentials!";
        }
    } else {
        $error = "Invalid credentials!";
    }
    
    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secure Login - SQLInjection Academy</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="login-page">
    <div class="container">
        <div class="login-box secure">
            <div class="logo">
                <img src="../assets/images/logo.png" alt="SQLInjection Academy" onerror="this.style.display='none'">
                <h1>🔒 Secure Login</h1>
            </div>
            <div class="success-banner">
                ✅ This login page uses prepared statements and is secure
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
            
            <div class="demo-credentials">
                <h3>🔑 Demo Credentials</h3>
                <ul>
                    <li><strong>Admin:</strong> admin / admin123</li>
                    <li><strong>User:</strong> john_doe / password123</li>
                </ul>
            </div>
            
            <div class="links">
                <a href="../vulnerable/login.php">Try Vulnerable Version</a>
                <a href="../index.html">Back to Home</a>
            </div>
        </div>
    </div>
</body>
</html>