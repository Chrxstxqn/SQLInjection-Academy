# 🛡️ Chapter 5: Defense Mechanisms

## Prevention is Key

Learn how to protect applications from SQL injection attacks.

## 1. Prepared Statements (Parameterized Queries)

### ✅ The Gold Standard

Prepared statements separate SQL logic from data.

#### PHP (MySQLi)
```php
// SECURE
$stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
$stmt->bind_param("ss", $username, $password);
$stmt->execute();
$result = $stmt->get_result();
```

#### PHP (PDO)
```php
// SECURE
$stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
$stmt->execute(['username' => $username]);
$user = $stmt->fetch();
```

#### Python (with MySQL)
```python
# SECURE
cursor = connection.cursor(prepared=True)
query = "SELECT * FROM users WHERE username = %s"
cursor.execute(query, (username,))
```

#### Node.js (with MySQL)
```javascript
// SECURE
const query = 'SELECT * FROM users WHERE username = ?';
connection.query(query, [username], (error, results) => {
    // Handle results
});
```

#### Java (JDBC)
```java
// SECURE
String query = "SELECT * FROM users WHERE username = ?";
PreparedStatement stmt = conn.prepareStatement(query);
stmt.setString(1, username);
ResultSet rs = stmt.executeQuery();
```

### Why Prepared Statements Work

1. **Separation of Code and Data**: SQL structure is sent first, parameters sent separately
2. **Automatic Escaping**: Database driver handles special characters
3. **Type Safety**: Parameters are typed (string, integer, etc.)
4. **No String Concatenation**: Data never becomes part of SQL command

## 2. Stored Procedures

### MySQL Stored Procedure
```sql
DELIMITER $$

CREATE PROCEDURE authenticate_user(
    IN p_username VARCHAR(50),
    IN p_password VARCHAR(255)
)
BEGIN
    SELECT * FROM users 
    WHERE username = p_username 
    AND password = p_password;
END$$

DELIMITER ;
```

### Calling from PHP
```php
$stmt = $conn->prepare("CALL authenticate_user(?, ?)");
$stmt->bind_param("ss", $username, $password);
$stmt->execute();
```

## 3. Input Validation

### Whitelist Validation

```php
// Only allow alphanumeric usernames
if (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
    die("Invalid username format");
}

// Validate email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("Invalid email format");
}

// Validate integer ID
$id = filter_var($_GET['id'], FILTER_VALIDATE_INT);
if ($id === false) {
    die("Invalid ID");
}
```

### Type Casting

```php
// Force to integer
$id = (int)$_GET['id'];

// Use intval
$page = intval($_GET['page']);
```

## 4. Escaping (Last Resort)

### ⚠️ Use Only When Prepared Statements Impossible

```php
// MySQLi
$username = mysqli_real_escape_string($conn, $_POST['username']);

// PDO
$username = $pdo->quote($_POST['username']);
```

**Note:** Escaping is NOT as secure as prepared statements!

## 5. Least Privilege Principle

### Database User Permissions

```sql
-- Create limited user
CREATE USER 'webapp'@'localhost' IDENTIFIED BY 'strong_password';

-- Grant only necessary permissions
GRANT SELECT, INSERT, UPDATE ON webapp_db.users TO 'webapp'@'localhost';
GRANT SELECT ON webapp_db.products TO 'webapp'@'localhost';

-- NO DROP, CREATE, or administrative privileges!
```

### Separate Database Users

```
Read-only user: For public search/display
Write user: For user actions (insert, update)
Admin user: For migrations only (never in app code)
```

## 6. Error Handling

### ❌ DON'T Expose Database Errors

```php
// BAD - Reveals database structure
try {
    $result = $conn->query($query);
} catch (Exception $e) {
    die($e->getMessage()); // NEVER DO THIS!
}
```

### ✅ DO Use Generic Error Messages

```php
// GOOD - Generic user message, log details
try {
    $result = $conn->query($query);
} catch (Exception $e) {
    error_log($e->getMessage()); // Log for developers
    die("An error occurred. Please try again."); // Show to user
}
```

## 7. Web Application Firewall (WAF)

### Popular WAF Solutions

- **ModSecurity** (Open source)
- **Cloudflare WAF**
- **AWS WAF**
- **Imperva**

### WAF Rules Example (ModSecurity)

```apache
SecRule ARGS "(union.*select|insert.*into|drop.*table)" \
    "id:1001,phase:2,block,msg:'SQL Injection Attempt'"
```

## 8. Content Security Policy (CSP)

While CSP doesn't prevent SQLi directly, it helps mitigate impact:

```html
<meta http-equiv="Content-Security-Policy" 
      content="default-src 'self'; script-src 'self'">
```

## Complete Secure Login Example

```php
<?php
session_start();
require_once 'config/database.php';

// Enable error logging (not displaying)
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', '/var/log/php_errors.log');

function secureLogin($username, $password) {
    // 1. Input validation
    if (empty($username) || empty($password)) {
        return ['success' => false, 'message' => 'All fields required'];
    }
    
    // 2. Whitelist validation
    if (!preg_match('/^[a-zA-Z0-9_]{3,20}$/', $username)) {
        return ['success' => false, 'message' => 'Invalid username format'];
    }
    
    // 3. Rate limiting (prevent brute force)
    if (isset($_SESSION['login_attempts']) && $_SESSION['login_attempts'] > 5) {
        return ['success' => false, 'message' => 'Too many attempts. Try later.'];
    }
    
    try {
        $conn = getConnection();
        
        // 4. Prepared statement
        $stmt = $conn->prepare("SELECT id, username, password, role FROM users WHERE username = ? AND status = 'active'");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            
            // 5. Password verification (hashed)
            if (password_verify($password, $user['password'])) {
                // 6. Regenerate session ID (prevent session fixation)
                session_regenerate_id(true);
                
                // 7. Set session variables
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['login_attempts'] = 0;
                
                // 8. Log successful login
                error_log("Successful login: " . $username);
                
                return ['success' => true, 'message' => 'Login successful'];
            }
        }
        
        // 9. Increment failed attempts
        $_SESSION['login_attempts'] = ($_SESSION['login_attempts'] ?? 0) + 1;
        
        // 10. Generic error message
        return ['success' => false, 'message' => 'Invalid credentials'];
        
    } catch (Exception $e) {
        // 11. Log error, show generic message
        error_log("Login error: " . $e->getMessage());
        return ['success' => false, 'message' => 'An error occurred'];
    } finally {
        if (isset($stmt)) $stmt->close();
        if (isset($conn)) $conn->close();
    }
}

// Usage
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $result = secureLogin($_POST['username'], $_POST['password']);
    
    if ($result['success']) {
        header('Location: dashboard.php');
        exit;
    } else {
        $error = $result['message'];
    }
}
?>
```

## Defense-in-Depth Strategy

### Layer 1: Input Validation
- Whitelist allowed characters
- Validate data types
- Check length limits

### Layer 2: Parameterized Queries
- Use prepared statements
- Never concatenate SQL
- Type-safe parameters

### Layer 3: Least Privilege
- Minimal database permissions
- Separate users for different functions
- No admin access from app

### Layer 4: Error Handling
- Log errors server-side
- Generic messages to users
- No stack traces in production

### Layer 5: Monitoring
- Log all database queries
- Alert on suspicious patterns
- Regular security audits

## Lab Exercise 5.1: Secure the Vulnerable Code

**Objective:** Refactor vulnerable code to be secure

**Original (Vulnerable):**
```php
$username = $_POST['username'];
$query = "SELECT * FROM users WHERE username='$username'";
$result = mysqli_query($conn, $query);
```

**Your Task:** Rewrite using prepared statements

<details>
<summary>Solution</summary>

```php
$username = $_POST['username'];

// Add input validation
if (!preg_match('/^[a-zA-Z0-9_]{3,20}$/', $username)) {
    die('Invalid username format');
}

// Use prepared statement
$stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
```
</details>

## Key Takeaways

- ✅ Prepared statements are the #1 defense
- ✅ Input validation adds an extra layer
- ✅ Never show database errors to users
- ✅ Use least privilege for database users
- ✅ Implement defense-in-depth
- ✅ Password hashing (bcrypt/Argon2)
- ✅ Rate limiting prevents brute force

## Quiz: Chapter 5

### Question 1
Best defense against SQL injection?
- A) Input validation
- B) Prepared statements ✅
- C) Escaping
- D) Firewalls

### Question 2
What should database errors show users?
- A) Full error message
- B) SQL query
- C) Generic message ✅
- D) Stack trace

### Question 3
What is defense-in-depth?
- A) Single strong defense
- B) Multiple security layers ✅
- C) Deep packet inspection
- D) Network segmentation

---

**[← Previous: Chapter 4](04-basic-techniques.md)** | **[Next: Chapter 6 →](06-tools.md)**