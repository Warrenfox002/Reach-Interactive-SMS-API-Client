# Reach Interactive SMS API - Composer Package Structure

## 📦 Package Overview

A complete, production-ready PHP composer package for the Reach Interactive SMS API with proper structure, documentation, and GitHub workflow configuration.

## 📁 Directory Structure

```
reach-interactive-sms-api/
├── .github/
│   └── workflows/
│       └── tests.yml                 # GitHub Actions CI/CD workflow
├── src/
│   ├── Exceptions/
│   │   ├── ReachInteractiveException.php
│   │   ├── ReachInteractiveAuthenticationException.php
│   │   ├── ReachInteractiveInsufficientCreditsException.php
│   │   ├── ReachInteractiveBadRequestException.php
│   │   ├── ReachInteractiveForbiddenException.php
│   │   ├── ReachInteractiveServiceException.php
│   │   └── ReachInteractiveUnavailableException.php
│   └── ReachInteractiveAPI.php        # Main API client class
├── examples/
│   └── index.php                      # Comprehensive usage examples
├── tests/                             # (Empty, ready for your tests)
├── .editorconfig                      # Code style configuration
├── .gitignore                         # Git ignore rules
├── composer.json                      # Composer package metadata
├── phpunit.xml.dist                   # PHPUnit test configuration
├── CHANGELOG.md                       # Version history
├── CONTRIBUTING.md                    # Contribution guidelines
├── LICENSE                            # MIT License
├── README.md                          # Full documentation
└── QUICKSTART.md                      # Quick start guide
```

## 📋 File Descriptions

### Core Files

| File | Purpose |
|------|---------|
| `composer.json` | Package metadata, dependencies, autoloading |
| `src/ReachInteractiveAPI.php` | Main API client class with all methods |
| `src/Exceptions/*.php` | Typed exception classes for error handling |

### Documentation

| File | Purpose |
|------|---------|
| `README.md` | Complete documentation with examples |
| `QUICKSTART.md` | Quick start guide for new users |
| `CHANGELOG.md` | Version history and release notes |
| `CONTRIBUTING.md` | Guidelines for contributors |
| `LICENSE` | MIT License |

### Configuration

| File | Purpose |
|------|---------|
| `composer.json` | PHP version requirements, dependencies |
| `.editorconfig` | Code style settings for editors |
| `.gitignore` | Files to ignore in git |

| `phpunit.xml.dist` | PHPUnit test configuration |
| `.github/workflows/tests.yml` | Automated tests on GitHub |

### Examples & Tests

| File | Purpose |
|------|---------|
| `examples/index.php` | 11 comprehensive usage examples |
| `tests/` | Directory for unit tests |

## 🚀 Getting Started

### 1. Update `composer.json`

Edit the following fields in `composer.json`:

```json
{
    "name": "yourusername/reach-interactive-sms-api",
    "authors": [
        {
            "name": "Your Name",
            "email": "your.email@example.com"
        }
    ]
}
```

### 2. Create GitHub Repository

```bash
# Initialize git (if not already done)
git init
git add .
git commit -m "Initial commit"

# Add remote repository
git remote add origin https://github.com/yourusername/reach-interactive-sms-api.git
git branch -M main
git push -u origin main
```

### 3. Publish to Packagist

1. Go to [Packagist.org](https://packagist.org)
2. Sign up/Login with GitHub
3. Click "Submit Package"
4. Enter your GitHub repository URL
5. Click "Check"
6. Click "Submit"

Your package will be available as `yourusername/reach-interactive-sms-api`

### 4. Installation via Composer

Users can now install your package with:

```bash
composer require yourusername/reach-interactive-sms-api
```

## 📦 Package Features

### Namespace Structure
```php
// All classes use PSR-4 autoloading under ReachInteractive namespace
use ReachInteractive\ReachInteractiveAPI;
use ReachInteractive\Exceptions\ReachInteractiveException;
```

### Composer Autoloading
```php
// Automatically loads when you require autoload.php
require_once 'vendor/autoload.php';
```

### Dependencies
- **PHP 8.0+** - Modern PHP with type hints and named arguments
- **ext-curl** - For HTTP requests
- **ext-json** - For JSON encoding/decoding

## 🧪 Testing & CI/CD

### Run Tests Locally
```bash
composer install
./vendor/bin/phpunit
```

### Automated Tests
GitHub Actions automatically runs tests on:
- Push to main/develop branches
- Pull requests
- PHP 8.0, 8.1, 8.2, 8.3

## 📚 Documentation Files

### README.md
- Feature overview
- Installation instructions
- API documentation with examples
- Error handling guide
- Best practices
- Troubleshooting

### QUICKSTART.md
- Installation steps
- Basic setup
- Common tasks
- Error handling examples
- Next steps

### CONTRIBUTING.md
- Code of conduct
- How to report bugs
- How to suggest features
- Pull request process
- Development setup
- Coding standards

## 🔧 Maintenance

### Version Management
Follow [Semantic Versioning](https://semver.org/):
- MAJOR.MINOR.PATCH (e.g., 1.0.0)
- Update CHANGELOG.md for each release

### Code Quality
```bash
# Check code style
./vendor/bin/phpcs --standard=PSR12 src/

# Fix code style
./vendor/bin/phpcbf --standard=PSR12 src/
```

## 📝 Environment Variables

Create `.env` from `.env.example` for local development:

```bash
cp .env.example .env
```

## 🎯 Next Steps

1. **Update composer.json** with your details
2. **Create GitHub repository** and push code
3. **Publish to Packagist** for public availability
4. **Write tests** in `tests/` directory
5. **Create releases** on GitHub
6. **Add badges** to README (build status, version, etc.)

## 📦 Installing in Your Project

Once published to Packagist:

```bash
composer require yourusername/reach-interactive-sms-api
```

Or from GitHub:

```bash
composer require yourusername/reach-interactive-sms-api:@dev
```

## 🤝 Contributing

The CONTRIBUTING.md file includes guidelines for:
- Reporting bugs
- Suggesting enhancements
- Creating pull requests
- Code style standards
- Testing requirements

## 📄 License

MIT License - Free for personal and commercial use

## 📞 Support

- GitHub Issues: Report bugs and feature requests
- Documentation: README.md and QUICKSTART.md
- Examples: See examples/index.php
- Reach Interactive API: https://www.reach-interactive.com/sms-api/api

---

This is a complete, professional PHP package ready for production use and GitHub/Packagist publication!
