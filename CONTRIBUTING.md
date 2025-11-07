# Contributing to SQLInjection Academy

First off, thank you for considering contributing to SQLInjection Academy! 🎉

This project aims to educate developers and security professionals about SQL injection vulnerabilities through practical, hands-on learning. Your contributions help make this resource better for everyone.

## 📖 Table of Contents

- [Code of Conduct](#code-of-conduct)
- [How Can I Contribute?](#how-can-i-contribute)
- [Development Setup](#development-setup)
- [Contribution Guidelines](#contribution-guidelines)
- [Style Guide](#style-guide)
- [Commit Messages](#commit-messages)
- [Pull Request Process](#pull-request-process)

## Code of Conduct

### Our Pledge

We are committed to providing a welcoming and inclusive environment for all contributors, regardless of:
- Experience level
- Gender identity and expression
- Sexual orientation
- Disability
- Personal appearance
- Race or ethnicity
- Age
- Religion
- Nationality

### Expected Behavior

- ✅ Be respectful and professional
- ✅ Welcome newcomers and help them learn
- ✅ Accept constructive criticism gracefully
- ✅ Focus on what's best for the community
- ✅ Show empathy towards others

### Unacceptable Behavior

- ❌ Harassment or discriminatory language
- ❌ Trolling or insulting comments
- ❌ Publishing others' private information
- ❌ Promoting illegal activities
- ❌ Any conduct inappropriate in a professional setting

## How Can I Contribute?

### 📝 Reporting Bugs

Before creating bug reports, please check existing issues to avoid duplicates.

**When reporting a bug, include:**
- Clear, descriptive title
- Steps to reproduce
- Expected behavior
- Actual behavior
- Screenshots (if applicable)
- Environment details:
  - PHP version
  - MySQL version
  - Operating system
  - Web server

**Example:**
```markdown
**Bug**: Login page displays error on valid credentials

**Steps to Reproduce:**
1. Navigate to /secure/login.php
2. Enter username: admin
3. Enter password: admin123
4. Click login

**Expected:** Successful login
**Actual:** Database connection error

**Environment:**
- PHP 8.0.25
- MySQL 8.0.31
- Windows 11
- XAMPP 8.0.25
```

### 💡 Suggesting Enhancements

**Enhancement requests should include:**
- Clear description of the enhancement
- Rationale (why it's useful)
- Possible implementation approach
- Examples or mockups (if applicable)

**Example:**
```markdown
**Enhancement**: Add chapter on Blind SQL Injection

**Rationale:** 
Blind SQLi is a common attack vector not covered in current curriculum. 
Students need to understand time-based and boolean-based techniques.

**Proposed Content:**
- Boolean-based blind SQLi
- Time-based blind SQLi
- Lab exercises
- Tool automation (SQLMap)
```

### 📚 Adding Course Content

We welcome new course chapters, exercises, and examples!

**New chapters should:**
- Follow existing chapter format
- Include practical examples
- Provide hands-on exercises
- Include quiz questions
- Link to related chapters

**Chapter template:**
```markdown
# 🎯 Chapter X: Title

## Introduction
[Overview of the topic]

## Key Concepts
### Concept 1
[Explanation]

### Concept 2
[Explanation]

## Practical Examples
[Code examples with explanations]

## Lab Exercise X.1: Title
**Objective:** [What students will learn]

**Steps:**
1. [Step 1]
2. [Step 2]

## Key Takeaways
- ✅ [Takeaway 1]
- ✅ [Takeaway 2]

## Quiz: Chapter X
[Quiz questions]

---
**[← Previous](link)** | **[Next →](link)**
```

### 🐛 Fixing Bugs

1. Check issue is not already assigned
2. Comment on the issue to claim it
3. Fork and create a branch
4. Make your fixes
5. Test thoroughly
6. Submit pull request

### 🌍 Translating

Help make this resource available in more languages!

**Translation process:**
1. Create `course/[language-code]/` directory
2. Translate all chapter files
3. Update navigation links
4. Add language selector to homepage
5. Update README with language info

## Development Setup

### Prerequisites
```bash
# Required
- PHP 7.4+
- MySQL 8.0+
- Git
- Code editor (VS Code recommended)

# Recommended
- XAMPP or MAMP
- MySQL Workbench
- Postman (for API testing)
```

### Setup Steps

1. **Fork the repository**
   - Click "Fork" on GitHub
   - Clone your fork locally

2. **Clone your fork**
```bash
git clone https://github.com/YOUR-USERNAME/SQLInjection-Academy.git
cd SQLInjection-Academy
```

3. **Add upstream remote**
```bash
git remote add upstream https://github.com/Chrxstxqn/SQLInjection-Academy.git
```

4. **Configure database**
```bash
# Edit config/database.php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'sqli_academy');
```

5. **Initialize database**
```bash
php setup/install.php
```

6. **Create a branch**
```bash
git checkout -b feature/your-feature-name
```

## Contribution Guidelines

### Code Contributions

**PHP Code:**
- Follow PSR-12 coding standards
- Add comments for complex logic
- Use meaningful variable names
- Validate all inputs
- Handle errors gracefully

**JavaScript:**
- Use ES6+ syntax
- Add JSDoc comments
- Validate user inputs
- Handle edge cases

**CSS:**
- Follow BEM naming convention
- Use CSS variables for colors
- Ensure responsive design
- Support dark/light modes

**Markdown:**
- Use proper heading hierarchy
- Include code syntax highlighting
- Add emojis for visual appeal
- Proofread for grammar/spelling

### Testing

**Before submitting:**
- ☑️ Test all new features
- ☑️ Verify no broken links
- ☑️ Check responsive design
- ☑️ Test on multiple browsers
- ☑️ Validate HTML/CSS
- ☑️ Run PHP syntax check
- ☑️ Test database operations

### Documentation

**Update documentation when:**
- Adding new features
- Changing existing functionality
- Fixing bugs that affect usage
- Adding new dependencies

## Style Guide

### PHP Style

```php
<?php
/**
 * Brief description
 * 
 * Detailed description if needed
 * 
 * @param string $username Username input
 * @param string $password Password input
 * @return array Result array
 */
function authenticateUser(string $username, string $password): array {
    // Validate inputs
    if (empty($username) || empty($password)) {
        return ['success' => false, 'message' => 'Required fields missing'];
    }
    
    // Use prepared statements
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    
    // Return result
    return ['success' => true, 'data' => $result];
}
?>
```

### Markdown Style

```markdown
# H1 - Chapter Title

## H2 - Main Section

### H3 - Subsection

**Bold** for emphasis
*Italic* for terminology
`code` for inline code

```language
code block
```

- Unordered list
1. Ordered list

> Quote or note

[Link text](url)
![Alt text](image-url)
```

## Commit Messages

### Format
```
<type>: <subject>

<body>

<footer>
```

### Types
- **feat:** New feature
- **fix:** Bug fix
- **docs:** Documentation changes
- **style:** Code style changes (formatting)
- **refactor:** Code refactoring
- **test:** Adding tests
- **chore:** Maintenance tasks

### Examples

**Good commits:**
```
feat: Add chapter 7 on blind SQL injection

Added comprehensive coverage of boolean-based and time-based
blind SQLi techniques with practical examples and exercises.

Closes #42
```

```
fix: Resolve database connection error in secure login

Fixed prepared statement binding issue that caused errors
when password contained special characters.

Fixes #38
```

**Bad commits:**
```
❌ Fixed stuff
❌ Update
❌ asdfasdf
❌ WIP
```

## Pull Request Process

### Before Submitting

1. **Update your fork**
```bash
git fetch upstream
git checkout main
git merge upstream/main
```

2. **Rebase your branch**
```bash
git checkout feature/your-feature
git rebase main
```

3. **Run tests**
```bash
php -l vulnerable/login.php
php -l secure/login.php
```

4. **Update documentation**
- Update README if needed
- Add JSDoc/PHPDoc comments
- Update CHANGELOG

### Submitting PR

1. **Push your branch**
```bash
git push origin feature/your-feature
```

2. **Create Pull Request**
- Go to your fork on GitHub
- Click "New Pull Request"
- Select your branch
- Fill in the template

### PR Template

```markdown
## Description
[Brief description of changes]

## Type of Change
- [ ] Bug fix
- [ ] New feature
- [ ] Documentation update
- [ ] Code refactoring

## Testing
- [ ] Tested on PHP 7.4
- [ ] Tested on PHP 8.0+
- [ ] Tested on MySQL 8.0
- [ ] Tested in Chrome
- [ ] Tested in Firefox
- [ ] Responsive design verified

## Screenshots
[If applicable]

## Checklist
- [ ] Code follows project style
- [ ] Comments added for complex code
- [ ] Documentation updated
- [ ] No console errors
- [ ] Tested thoroughly

## Related Issues
Closes #[issue number]
```

### Review Process

1. Maintainer reviews code
2. Feedback provided if changes needed
3. You make requested changes
4. Maintainer approves
5. PR merged into main

## Recognition

Contributors will be:
- Listed in README acknowledgments
- Credited in relevant documentation
- Mentioned in release notes

## Questions?

Feel free to:
- Open an issue
- Start a discussion
- Contact maintainer

---

**Thank you for contributing! 🚀**