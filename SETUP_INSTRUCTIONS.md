# Setup Instructions - Publishing to GitHub & Packagist

This guide walks you through publishing your Reach Interactive SMS API package to GitHub and Packagist.

## 📋 Pre-requisites

✅ GitHub account (https://github.com/signup)  
✅ Packagist account (sign up with GitHub at https://packagist.org)  
✅ Git installed on your machine  
✅ All package files created in `reach-interactive-sms-api` directory  

## Step 1: Prepare Your Package (LOCAL)

### 1.1 Update Package Information

Edit `composer.json` and update these fields:

```json
{
    "name": "yourusername/reach-interactive-sms-api",
    "description": "A comprehensive PHP client library for the Reach Interactive SMS API",
    "license": "MIT",
    "type": "library",
    "authors": [
        {
            "name": "Your Full Name",
            "email": "your.email@example.com",
            "homepage": "https://yourwebsite.com",
            "role": "Developer"
        }
    ]
}
```

**Example:**
```json
{
    "name": "warre/reach-interactive-sms-api",
    "authors": [
        {
            "name": "Warre van der Linde",
            "email": "warre@example.com"
        }
    ]
}
```

### 1.2 Verify Package Name

Choose your package name wisely:
- Must be in format `vendor/package-name`
- `vendor` = your GitHub username (e.g., `warre`)
- `package-name` = package name (e.g., `reach-interactive-sms-api`)
- Use hyphens for multi-word names, never underscores

### 1.3 Update README.md (Optional)

Update any references to your username:
```markdown
composer require yourusername/reach-interactive-sms-api
```

### 1.4 Test Package Locally

```bash
cd reach-interactive-sms-api

# Validate composer.json
composer validate

# Install dependencies
composer install

# Run any existing tests
composer test
```

## Step 2: Create GitHub Repository

### 2.1 Create New Repository on GitHub

1. Go to https://github.com/new
2. Fill in repository details:
   - **Repository name:** `reach-interactive-sms-api` (must match composer.json)
   - **Description:** "A comprehensive PHP client library for the Reach Interactive SMS API"
   - **Public:** ✅ (so Packagist can access it)
   - **Initialize with README:** ❌ (we have our own)
   - **Add .gitignore:** ❌ (we have our own)
   - **Choose a license:** MIT
3. Click "Create repository"

### 2.2 Push Code to GitHub

From your `reach-interactive-sms-api` directory:

```bash
# Initialize git (if not already done)
git init

# Add all files
git add .

# Create initial commit
git commit -m "Initial commit: Reach Interactive SMS API PHP client"

# Add remote
git remote add origin https://github.com/yourusername/reach-interactive-sms-api.git

# Rename branch to main if needed
git branch -M main

# Push to GitHub
git push -u origin main
```

**Check:** Visit `https://github.com/yourusername/reach-interactive-sms-api` - your code should be there!

## Step 3: Create GitHub Release

### 3.1 Create a Release Tag

```bash
# Create a git tag for version 1.0.0
git tag -a v1.0.0 -m "Release version 1.0.0"

# Push the tag to GitHub
git push origin v1.0.0
```

### 3.2 Create Release on GitHub

1. Go to your repository on GitHub
2. Click "Releases" or go to `/releases`
3. Click "Create a new release"
4. Fill in:
   - **Tag version:** `v1.0.0`
   - **Release title:** "Version 1.0.0 - Initial Release"
   - **Description:**
     ```markdown
     ## Initial Release
     
     - Send SMS messages
     - Check account balance
     - Manage scheduled messages
     - JWT token authentication
     - Comprehensive error handling
     ```
5. ✅ Check "This is a pre-release" (optional)
6. Click "Publish release"

## Step 4: Publish to Packagist

### 4.1 Sign Up / Login to Packagist

1. Go to https://packagist.org
2. Click "Sign up" or "GitHub" to sign in with GitHub

### 4.2 Submit Package

1. Click "Submit Package" button
2. Enter your repository URL:
   ```
   https://github.com/yourusername/reach-interactive-sms-api
   ```
3. Click "Check"
4. Click "Submit"

**Wait:** Packagist will validate your package. This may take a few minutes.

### 4.3 Enable Auto-Update (Recommended)

1. Go to your package on Packagist: `https://packagist.org/packages/yourusername/reach-interactive-sms-api`
2. Click "Settings"
3. Go to "GitHub Service Hook"
4. Copy the URL shown
5. Go to GitHub repository Settings → Webhooks
6. Click "Add webhook"
7. Paste the URL
8. Select "Push events"
9. Click "Add webhook"

Now your package automatically updates when you push to GitHub!

## Step 5: Installation Test

### 5.1 Create a Test Directory

```bash
mkdir test-reach-sms
cd test-reach-sms

composer init
```

### 5.2 Install Your Package

```bash
composer require yourusername/reach-interactive-sms-api
```

### 5.3 Test Usage

Create `test.php`:

```php
<?php

require_once 'vendor/autoload.php';

use ReachInteractive\ReachInteractiveAPI;

$api = new ReachInteractiveAPI('user', 'pass');
echo "✓ Package installed and loaded successfully!";
```

Run it:
```bash
php test.php
```

If you see `✓ Package installed and loaded successfully!` - **Success!**

## 📦 Share Your Package

### Packagist Page
- URL: `https://packagist.org/packages/yourusername/reach-interactive-sms-api`
- Badge: `[![Latest Stable Version](https://img.shields.io/packagist/v/yourusername/reach-interactive-sms-api.svg)](https://packagist.org/packages/yourusername/reach-interactive-sms-api)`

### Installation Command
```bash
composer require yourusername/reach-interactive-sms-api
```

### Add Badges to README

Add to your README.md:

```markdown
[![Latest Stable Version](https://img.shields.io/packagist/v/yourusername/reach-interactive-sms-api.svg?style=flat-square)](https://packagist.org/packages/yourusername/reach-interactive-sms-api)
[![Total Downloads](https://img.shields.io/packagist/dt/yourusername/reach-interactive-sms-api.svg?style=flat-square)](https://packagist.org/packages/yourusername/reach-interactive-sms-api)
[![License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
```

## 🔄 Future Updates

### When You Update Your Code

```bash
# Make changes to your code

# Commit
git add .
git commit -m "Fix: Description of what changed"

# Create new tag
git tag -a v1.0.1 -m "Release version 1.0.1"

# Push
git push origin main
git push origin v1.0.1

# Update CHANGELOG.md with the new version
```

Packagist will automatically fetch the new version!

## 📚 Next Steps After Publishing

- [ ] Share on Reddit (r/PHP, r/laravel, etc.)
- [ ] Share on Twitter with #PHP #Composer
- [ ] Add to your portfolio/resume
- [ ] Consider adding automated tests
- [ ] Create a SECURITY.md policy
- [ ] Set up code coverage reporting
- [ ] Add issue templates
- [ ] Create pull request templates

## 🆘 Troubleshooting

### Package Not Showing on Packagist

- ✓ Repository must be public
- ✓ composer.json must be valid (`composer validate`)
- ✓ Package must have a version tag (v1.0.0)
- ✓ Repository name must match composer.json name

### Installation Fails

```bash
# Clear composer cache
composer clearcache

# Try again
composer require yourusername/reach-interactive-sms-api
```

### Changes Not Updating

- Wait 12 hours for Packagist to sync
- Or manually trigger update in package settings

## 📝 Useful Links

- **Composer Docs:** https://getcomposer.org/doc/
- **Packagist:** https://packagist.org/
- **GitHub:** https://github.com/
- **Semantic Versioning:** https://semver.org/
- **Composer Best Practices:** https://getcomposer.org/doc/04-schema.md

## ✅ Checklist

Use this checklist to ensure everything is ready:

- [ ] Updated `composer.json` with correct name and info
- [ ] Created GitHub account and repository
- [ ] Pushed code to GitHub
- [ ] Created v1.0.0 tag on GitHub
- [ ] Created release on GitHub
- [ ] Signed up on Packagist
- [ ] Submitted package to Packagist
- [ ] Package appears on Packagist
- [ ] Installation via composer works
- [ ] Added GitHub webhook to Packagist (optional but recommended)
- [ ] Updated README with Packagist badge
- [ ] Shared package with community

---

**Congratulations!** Your package is now publicly available on Packagist and can be installed by anyone with `composer require yourusername/reach-interactive-sms-api` 🎉
