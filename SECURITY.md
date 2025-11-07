# Security Policy

## 🛡️ Purpose of This Project

**SQLInjection Academy is an educational project designed to teach SQL injection vulnerabilities in a safe, controlled environment.**

The vulnerable code in this repository is **intentionally insecure** for learning purposes. This is not a bug — it's a feature for educational demonstration.

## ⚠️ Expected Vulnerabilities

The following vulnerabilities exist **by design** for educational purposes:

### Intentionally Vulnerable Components

- **`/vulnerable/login.php`** - SQL injection vulnerability (educational)
- **`/vulnerable/dashboard.php`** - Unsafe query construction (educational)
- Direct user input concatenation in SQL queries (educational examples)

### Secure Components

- **`/secure/login.php`** - Implements prepared statements (safe)
- **`/secure/dashboard.php`** - Uses parameterized queries (safe)
- Configuration files with proper access controls

## 🐛 Reporting Security Issues

### What to Report

**Please report security issues that are NOT intentional educational vulnerabilities:**

✅ **Report these:**
- Security issues in the "secure" implementations
- Authentication bypass in secure login
- XSS vulnerabilities in any component
- CSRF vulnerabilities
- Path traversal issues
- Information disclosure (beyond educational scope)
- Privilege escalation
- Remote code execution
- SQL injection in "secure" components

❌ **Don't report these (expected):**
- SQL injection in `/vulnerable/` directory
- Authentication bypass in vulnerable login
- Any intentional vulnerability clearly marked as educational

### How to Report

**For legitimate security issues:**

1. **DO NOT** open a public issue
2. **DO** email the maintainer directly:
   - Email: [Your email or create one for this]
   - Subject: "[SECURITY] SQLInjection-Academy"
3. **DO** include:
   - Description of the vulnerability
   - Steps to reproduce
   - Potential impact
   - Suggested fix (if you have one)

### Response Timeline

- **Initial response:** Within 48 hours
- **Status update:** Within 7 days
- **Fix timeline:** Depends on severity
  - Critical: 1-7 days
  - High: 7-14 days
  - Medium: 14-30 days
  - Low: 30-60 days

## 🛠️ Supported Versions

| Version | Supported |
|---------|----------|
| main (latest) | ✅ Yes |
| Older releases | ❌ No |

We only support the latest version from the `main` branch.

## 🔒 Security Best Practices for Users

### Deployment

❌ **NEVER deploy this to production or public servers**

This project contains intentionally vulnerable code and should ONLY be used:
- In isolated lab environments
- On local development machines
- Behind firewalls with no public access
- For educational purposes only

### Network Security

```bash
# Good: Localhost only
http://localhost/SQLInjection-Academy/
http://127.0.0.1/SQLInjection-Academy/

# Bad: Publicly accessible
http://your-public-ip/SQLInjection-Academy/ ❌
http://yourdomain.com/SQLInjection-Academy/ ❌
```

### Database Security

```php
// Good: Separate database for learning
define('DB_NAME', 'sqli_academy'); ✅

// Bad: Using production database
define('DB_NAME', 'production_db'); ❌
```

### Access Control

- Use localhost-only access
- Don't expose on public networks
- Use separate MySQL user with limited privileges
- Never use root database credentials in production

## 📚 Security Learning Resources

This project is designed to teach security concepts. To learn more:

- [OWASP Top 10](https://owasp.org/www-project-top-ten/)
- [OWASP SQL Injection](https://owasp.org/www-community/attacks/SQL_Injection)
- [PortSwigger Web Security Academy](https://portswigger.net/web-security)
- [Course materials in `/course/` directory](course/)

## ⚖️ Legal and Ethical Guidelines

### Legal Use

✅ **Permitted:**
- Educational use in academic settings
- Personal learning and skill development
- Security training courses
- Ethical hacking practice (on owned systems)
- Security research in isolated environments

❌ **Prohibited:**
- Testing on systems you don't own
- Testing without explicit written permission
- Using techniques for malicious purposes
- Distributing exploit tools for illegal use
- Unauthorized access to any system

### Ethical Responsibilities

If you discover a vulnerability in a real system while learning:

1. **DO NOT exploit it further**
2. **DO follow responsible disclosure:**
   - Contact the organization privately
   - Give them time to fix (typically 90 days)
   - Don't publicly disclose until fixed
3. **DO respect bug bounty programs** if they exist
4. **DO NOT sell vulnerabilities on black markets**

## 📝 Changelog

### Security Updates

Security updates will be documented here:

- **2025-11-07:** Initial security policy created

## 👤 Contact

**Maintainer:** Christian Schito ([@Chrxstxqn](https://github.com/Chrxstxqn))

**For security issues:** [Create security advisory on GitHub]

**For general questions:** [Open an issue](https://github.com/Chrxstxqn/SQLInjection-Academy/issues)

---

## 🚨 Reminder

**This project contains intentionally vulnerable code for educational purposes.**

- ✅ Use responsibly
- ✅ Learn ethically
- ✅ Practice legally
- ✅ Respect privacy
- ✅ Follow the law

**Thank you for being a responsible security learner! 🔒**