# 📘 Chapter 2: SQL Basics Review

## SQL Fundamentals

Before diving into SQL injection, let's review essential SQL concepts.

## Basic SQL Commands

### SELECT Statement
```sql
-- Retrieve all columns
SELECT * FROM users;

-- Retrieve specific columns
SELECT username, email FROM users;

-- With condition
SELECT * FROM users WHERE id = 1;
```

### WHERE Clause
```sql
-- Equality
SELECT * FROM users WHERE username = 'admin';

-- Multiple conditions (AND)
SELECT * FROM users WHERE username = 'admin' AND role = 'admin';

-- Multiple conditions (OR)
SELECT * FROM users WHERE role = 'admin' OR role = 'moderator';

-- LIKE operator
SELECT * FROM users WHERE email LIKE '%@gmail.com';
```

### INSERT Statement
```sql
INSERT INTO users (username, password, email) 
VALUES ('newuser', 'pass123', 'user@example.com');
```

### UPDATE Statement
```sql
UPDATE users 
SET email = 'newemail@example.com' 
WHERE username = 'admin';
```

### DELETE Statement
```sql
DELETE FROM users WHERE id = 5;
```

## SQL Comments

Comments are crucial for SQL injection attacks:

### Single-line Comments
```sql
-- This is a comment
SELECT * FROM users; -- Inline comment
```

### Multi-line Comments
```sql
/* This is a
   multi-line
   comment */
SELECT * FROM users;
```

### Hash Comments (MySQL)
```sql
# This is also a comment in MySQL
SELECT * FROM users;
```

## SQL Operators

### Comparison Operators
```sql
=   -- Equal
!=  -- Not equal
<>  -- Not equal (alternative)
>   -- Greater than
<   -- Less than
>=  -- Greater than or equal
<=  -- Less than or equal
```

### Logical Operators
```sql
AND  -- Both conditions must be true
OR   -- At least one condition must be true
NOT  -- Negates a condition
```

### Special Operators
```sql
IN     -- Match any value in a list
LIKE   -- Pattern matching
BETWEEN -- Range checking
IS NULL -- Check for NULL values
```

## String Manipulation

### Concatenation
```sql
-- MySQL
SELECT CONCAT(username, '@', domain) FROM users;

-- SQL Server
SELECT username + '@' + domain FROM users;

-- PostgreSQL
SELECT username || '@' || domain FROM users;
```

### String Functions
```sql
-- Length
SELECT LENGTH(username) FROM users;

-- Substring
SELECT SUBSTRING(email, 1, 5) FROM users;

-- Upper/Lower case
SELECT UPPER(username) FROM users;
SELECT LOWER(email) FROM users;
```

## UNION Operator

Combines results from multiple SELECT statements:

```sql
SELECT username FROM users
UNION
SELECT email FROM customers;
```

**Requirements:**
- Same number of columns
- Compatible data types
- Column order matters

## Database Information Schema

### MySQL Information Schema
```sql
-- List all databases
SELECT schema_name FROM information_schema.schemata;

-- List all tables
SELECT table_name FROM information_schema.tables 
WHERE table_schema = 'database_name';

-- List all columns
SELECT column_name FROM information_schema.columns 
WHERE table_name = 'users';
```

## SQL Injection Context

### How Comments Break Queries

**Original query:**
```sql
SELECT * FROM users WHERE username='INPUT1' AND password='INPUT2'
```

**Attack with comment:**
```
INPUT1: admin' --
```

**Resulting query:**
```sql
SELECT * FROM users WHERE username='admin' -- ' AND password='INPUT2'
```

### How OR Conditions Bypass Authentication

**Attack with OR:**
```
INPUT1: ' OR '1'='1
```

**Resulting query:**
```sql
SELECT * FROM users WHERE username='' OR '1'='1' AND password='INPUT2'
```

Since `'1'='1'` is always true, the query returns all users!

## Practice Exercises

### Exercise 2.1: Basic Queries
Write SQL queries for the following:

1. Select all users with role 'admin'
2. Find users whose email contains 'gmail'
3. Count total number of users
4. Get the 5 most recently created users

**Solutions:**
```sql
-- 1.
SELECT * FROM users WHERE role = 'admin';

-- 2.
SELECT * FROM users WHERE email LIKE '%gmail%';

-- 3.
SELECT COUNT(*) FROM users;

-- 4.
SELECT * FROM users ORDER BY created_at DESC LIMIT 5;
```

### Exercise 2.2: Understanding Comments
What will these queries return?

```sql
-- Query 1
SELECT * FROM users WHERE username='admin' -- AND password='wrong';

-- Query 2
SELECT * FROM users WHERE username='admin' /* AND password='wrong' */;

-- Query 3
SELECT * FROM users WHERE username='admin' # AND password='wrong';
```

**Answer:** All three queries return the admin user because the password check is commented out!

### Exercise 2.3: UNION Practice
Construct a UNION query that combines usernames from 'users' table with product names from 'products' table.

**Solution:**
```sql
SELECT username AS name FROM users
UNION
SELECT product_name AS name FROM products;
```

## Key Takeaways

- ✅ SQL comments (`--`, `#`, `/* */`) can terminate queries early
- ✅ OR conditions can bypass authentication logic
- ✅ UNION can combine data from different tables
- ✅ Information schema reveals database structure
- ✅ String concatenation varies by database type

## Quiz: Chapter 2

### Question 1
Which SQL comment syntax works in MySQL?
- A) // 
- B) -- ✅
- C) %%
- D) ##

### Question 2
What does UNION require?
- A) Same number of columns ✅
- B) Same table names
- C) Same database
- D) Administrator access

### Question 3
What does `'1'='1'` evaluate to?
- A) Error
- B) False
- C) True ✅
- D) NULL

---

**[← Previous: Chapter 1](01-introduction.md)** | **[Next: Chapter 3 →](03-vulnerability-identification.md)**