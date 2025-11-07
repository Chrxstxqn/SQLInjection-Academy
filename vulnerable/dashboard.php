<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];
$role = $_SESSION['role'];

$conn = getConnection();
$query = "SELECT * FROM users WHERE id = $user_id";
$result = $conn->query($query);
$user = $result->fetch_assoc();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - SQLInjection Academy</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="container">
        <div class="dashboard">
            <h1>🎉 Welcome, <?php echo htmlspecialchars($username); ?>!</h1>
            <div class="success-message">
                <p>✅ You successfully logged in!</p>
                <p><strong>Role:</strong> <?php echo htmlspecialchars($role); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
            </div>
            
            <div class="user-info">
                <h2>User Information</h2>
                <table>
                    <tr>
                        <th>ID</th>
                        <td><?php echo htmlspecialchars($user['id']); ?></td>
                    </tr>
                    <tr>
                        <th>Username</th>
                        <td><?php echo htmlspecialchars($user['username']); ?></td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                    </tr>
                    <tr>
                        <th>Role</th>
                        <td><?php echo htmlspecialchars($user['role']); ?></td>
                    </tr>
                    <tr>
                        <th>Created</th>
                        <td><?php echo htmlspecialchars($user['created_at']); ?></td>
                    </tr>
                </table>
            </div>
            
            <div class="actions">
                <a href="logout.php" class="btn btn-secondary">Logout</a>
                <a href="../index.html" class="btn btn-primary">Back to Home</a>
            </div>
        </div>
    </div>
</body>
</html>