# 🎓 SQLInjection Academy

<div align="center">

![SQL Injection](https://img.shields.io/badge/Topic-SQL%20Injection-e74c3c)
![Educational](https://img.shields.io/badge/Purpose-Educational-27ae60)
![License](https://img.shields.io/badge/License-MIT-3498db)
![PHP](https://img.shields.io/badge/PHP-7.4+-777BB4?logo=php)
![MySQL](https://img.shields.io/badge/MySQL-8.0+-4479A1?logo=mysql)

**Learn SQL Injection Through Hands-On Practice**

*A comprehensive learning platform with vulnerable login pages, interactive labs, and security tutorials for ethical hacking education.*

[Demo](#-quick-start) · [Course](#-course-contents) · [Installation](#-installation) · [Contributing](#-contributing)

</div>

---

## 👁️ Overview

SQLInjection Academy is a complete educational platform designed to teach SQL injection vulnerabilities through practical, hands-on experience. This repository contains:

- **Vulnerable PHP Login Page** - Intentionally insecure for learning
- **Secure PHP Login Page** - Best practices implementation
- **Complete Course Material** - 6 chapters covering theory to advanced techniques
- **Interactive Labs** - Practice exercises with real code
- **Professional Tools Guide** - SQLMap, Burp Suite, OWASP ZAP tutorials

## ✨ Features

### 📚 Comprehensive Curriculum
- From basics to advanced SQL injection techniques
- Theory backed by practical examples
- Quizzes and lab exercises
- Real-world attack scenarios

### 🛡️ Hands-On Learning
- Live vulnerable and secure login implementations
- Side-by-side code comparison
- Database setup and configuration
- Step-by-step exploitation guides

### 🛠️ Professional Tools
- SQLMap automation tutorials
- Burp Suite intercept techniques
- OWASP ZAP scanning
- Manual testing with cURL

### ✅ Security Best Practices
- Prepared statements implementation
- Input validation techniques
- Error handling strategies
- Defense-in-depth approach

## 🚀 Quick Start

### Prerequisites

```bash
# Required
- PHP 7.4 or higher
- MySQL 8.0 or MariaDB 10.3+
- Web server (Apache/Nginx) or XAMPP/MAMP

# Optional for testing
- SQLMap
- Burp Suite
- OWASP ZAP
```

### Installation

1. **Clone the repository**
```bash
git clone https://github.com/Chrxstxqn/SQLInjection-Academy.git
cd SQLInjection-Academy
```

2. **Configure database**
```bash
# Edit config/database.php with your MySQL credentials
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'sqli_academy');
```

3. **Set up database**
```bash
# Option 1: Visit setup page in browser
http://localhost/SQLInjection-Academy/setup/install.php

# Option 2: Run PHP setup script
php setup/install.php

# Option 3: Import SQL manually
mysql -u root -p < setup/database.sql
```

4. **Verify installation**
```bash
# Check environment
http://localhost/SQLInjection-Academy/setup/check.php

# Open homepage
http://localhost/SQLInjection-Academy/
```

### Quick Test

**Try Vulnerable Login:**
```
URL: http://localhost/SQLInjection-Academy/vulnerable/login.php
Username: admin' --
Password: (anything)
Result: ✅ Bypassed authentication!
```

**Try Secure Login:**
```
URL: http://localhost/SQLInjection-Academy/secure/login.php
Username: admin
Password: admin123
Result: ✅ Proper authentication
```

## 📚 Course Contents

### [Chapter 1: Introduction to SQL Injection](course/01-introduction.md)
- What is SQL Injection?
- Real-world impact and famous breaches
- OWASP Top 10 ranking
- Ethical considerations and legal warnings
- Learning objectives

### [Chapter 2: SQL Basics Review](course/02-sql-basics.md)
- SQL fundamentals (SELECT, WHERE, UNION)
- SQL comments (--, #, /* */)
- Operators and string manipulation
- Information schema exploration
- Practice exercises

### [Chapter 3: Vulnerability Identification](course/03-vulnerability-identification.md)
- Recognizing vulnerable code patterns
- String concatenation dangers
- Testing methodologies
- Vulnerable vs Secure code comparison
- Black-box testing techniques

### [Chapter 4: Basic SQL Injection Techniques](course/04-basic-techniques.md)
- Authentication bypass methods
- Comment-based exploitation
- OR-based attacks
- UNION-based data extraction
- Error-based injection
- Real-world scenarios

### [Chapter 5: Defense Mechanisms](course/05-defense-mechanisms.md)
- Prepared statements (gold standard)
- Input validation strategies
- Stored procedures
- Least privilege principle
- Error handling best practices
- Complete secure implementation

### [Chapter 6: SQL Injection Testing Tools](course/06-tools.md)
- SQLMap comprehensive guide
- Burp Suite tutorials
- OWASP ZAP automation
- Manual testing with cURL
- Tool comparison and best practices

## 🎯 Lab Exercises

### Lab 1: Authentication Bypass
**Objective:** Bypass login using SQL injection

```
1. Navigate to /vulnerable/login.php
2. Try: admin' --
3. Try: ' OR '1'='1
4. Document successful payloads
5. Explain why each worked
```

### Lab 2: Data Extraction
**Objective:** Extract user data using UNION injection

```
1. Determine column count with ORDER BY
2. Identify vulnerable columns
3. Extract database information
4. List tables and columns
5. Dump user credentials
```

### Lab 3: Secure Implementation
**Objective:** Refactor vulnerable code

```
1. Identify vulnerabilities in provided code
2. Implement prepared statements
3. Add input validation
4. Test against attack payloads
5. Verify security improvements
```

## 🛠️ Testing with SQLMap

### Basic Scan
```bash
sqlmap -u "http://localhost/SQLInjection-Academy/vulnerable/login.php" \
       --data="username=test&password=test" \
       --batch
```

### List Databases
```bash
sqlmap -u "http://localhost/SQLInjection-Academy/vulnerable/login.php" \
       --data="username=test&password=test" \
       --dbs
```

### Dump Users Table
```bash
sqlmap -u "http://localhost/SQLInjection-Academy/vulnerable/login.php" \
       --data="username=test&password=test" \
       -D sqli_academy \
       -T users \
       --dump
```

## 📁 Project Structure

```
SQLInjection-Academy/
├── 📂 config/
│   └── database.php          # Database configuration
├── 🔓 vulnerable/
│   ├── login.php             # Vulnerable login page
│   ├── dashboard.php         # Dashboard after login
│   └── logout.php            # Logout functionality
├── 🔒 secure/
│   ├── login.php             # Secure login implementation
│   ├── dashboard.php         # Secure dashboard
│   └── logout.php            # Secure logout
├── 📚 course/
│   ├── 01-introduction.md
│   ├── 02-sql-basics.md
│   ├── 03-vulnerability-identification.md
│   ├── 04-basic-techniques.md
│   ├── 05-defense-mechanisms.md
│   └── 06-tools.md
├── 🎨 assets/
│   ├── css/
│   │   └── style.css           # Modern dark theme
│   └── images/
│       └── logo.png             # Project logo
├── 🛠️ setup/
│   ├── install.php           # Database setup script
│   └── check.php             # Environment verification
├── index.html                # Homepage
├── README.md                 # This file
├── LICENSE                   # MIT License
└── .gitignore                # Git ignore rules
```

## 🔑 Demo Credentials

| Username | Password | Role |
|----------|----------|------|
| admin | admin123 | admin |
| john_doe | password123 | user |
| alice | alice2024 | user |
| bob_smith | secure456 | user |
| charlie | charlie789 | moderator |

## ⚠️ Legal Disclaimer

### 🚨 IMPORTANT: READ BEFORE USE

**This repository is for EDUCATIONAL PURPOSES ONLY.**

The code in this repository is intentionally vulnerable for learning purposes. You must:

- ❌ **NEVER** use these techniques on systems you don't own
- ❌ **NEVER** test without explicit written permission
- ❌ **NEVER** use for malicious purposes
- ✅ **ALWAYS** practice in isolated lab environments
- ✅ **ALWAYS** follow ethical hacking guidelines
- ✅ **ALWAYS** respect the law

**Unauthorized access to computer systems is illegal and punishable by law.**

### Legal Framework

- **United States:** Computer Fraud and Abuse Act (CFAA)
- **Europe:** General Data Protection Regulation (GDPR), Computer Misuse Act
- **International:** Budapest Convention on Cybercrime

**Penalties can include:**
- Criminal prosecution
- Substantial fines
- Imprisonment
- Civil lawsuits

### Ethical Guidelines

1. **Get Permission:** Always obtain written authorization
2. **Scope Boundaries:** Stay within agreed testing scope
3. **No Harm:** Don't damage systems or data
4. **Confidentiality:** Protect discovered information
5. **Responsible Disclosure:** Report vulnerabilities properly

## 🎯 Learning Path

### Beginner (Weeks 1-2)
1. Read Chapters 1-3
2. Complete basic quizzes
3. Practice on vulnerable login
4. Understand the vulnerability

### Intermediate (Weeks 3-4)
1. Read Chapters 4-5
2. Complete all lab exercises
3. Learn SQLMap basics
4. Implement secure code

### Advanced (Weeks 5-6)
1. Read Chapter 6
2. Master professional tools
3. Practice complex scenarios
4. Build secure applications

## 👥 Contributing

Contributions are welcome! Here's how:

1. **Fork the repository**
2. **Create a feature branch**
   ```bash
   git checkout -b feature/new-chapter
   ```
3. **Make your changes**
4. **Commit with clear messages**
   ```bash
   git commit -m "Add: Chapter 7 - Blind SQL Injection"
   ```
5. **Push to your fork**
   ```bash
   git push origin feature/new-chapter
   ```
6. **Open a Pull Request**

### Contribution Ideas
- 📝 Additional course chapters
- 🛠️ More lab exercises
- 🐛 Bug fixes and improvements
- 🌍 Translations
- 🎨 UI/UX enhancements

## 📚 Resources

### Official Documentation
- [OWASP SQL Injection](https://owasp.org/www-community/attacks/SQL_Injection)
- [OWASP Top 10](https://owasp.org/www-project-top-ten/)
- [PHP Prepared Statements](https://www.php.net/manual/en/mysqli.quickstart.prepared-statements.php)

### Tools
- [SQLMap](https://sqlmap.org/)
- [Burp Suite](https://portswigger.net/burp)
- [OWASP ZAP](https://www.zaproxy.org/)

### Learning Platforms
- [PortSwigger Web Security Academy](https://portswigger.net/web-security)
- [HackTheBox](https://www.hackthebox.com/)
- [TryHackMe](https://tryhackme.com/)

## 💬 FAQ

**Q: Is this safe to practice on?**
A: Yes, in your local environment. Never deploy to public servers.

**Q: Can I use this for my security course?**
A: Absolutely! That's what it's designed for.

**Q: Is the vulnerable code realistic?**
A: Yes, it mirrors common real-world vulnerabilities.

**Q: What if I find a bug?**
A: Please open an issue on GitHub!

**Q: Can I contribute?**
A: Yes! See the Contributing section above.

## 🏆 Acknowledgments

- OWASP Foundation for security guidelines
- PortSwigger for Burp Suite and educational content
- SQLMap developers for the powerful tool
- Security community for continuous research

## 📝 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 👨‍💻 Author

**Christian Schito** ([@Chrxstxqn](https://github.com/Chrxstxqn))

- 🚀 Flutter & TypeScript Developer
- 🔐 Cybersecurity Enthusiast
- 🎓 Educator & Open Source Contributor

## ⭐ Support

If you find this project helpful, please:
- ⭐ Star this repository
- 👁️ Watch for updates
- 💌 Share with others
- 🐛 Report issues
- 💡 Suggest improvements

---

<div align="center">

**Built with ❤️ for Security Education**

[Report Bug](https://github.com/Chrxstxqn/SQLInjection-Academy/issues) · [Request Feature](https://github.com/Chrxstxqn/SQLInjection-Academy/issues) · [Discussions](https://github.com/Chrxstxqn/SQLInjection-Academy/discussions)

</div>