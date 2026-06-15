# Contributing

Thank you for considering contributing to the Reach Interactive SMS API PHP Client! We appreciate your help in making this project better.

## Code of Conduct

Be respectful and inclusive in all interactions. We're committed to fostering a welcoming and harassment-free environment for all contributors.

## How to Contribute

### Reporting Bugs

Before creating bug reports, please check the issue list as you might find out that you don't need to create one. When you are creating a bug report, please include as many details as possible:

- **Use a clear and descriptive title**
- **Describe the exact steps which reproduce the problem**
- **Provide specific examples to demonstrate the steps**
- **Describe the behavior you observed after following the steps**
- **Explain which behavior you expected to see instead and why**
- **Include code samples** that demonstrate the problem
- **Include PHP version and environment details**

### Suggesting Enhancements

Enhancement suggestions are tracked as GitHub issues. When creating an enhancement suggestion, please include:

- **Use a clear and descriptive title**
- **Provide a step-by-step description of the suggested enhancement**
- **Provide specific examples to demonstrate the steps**
- **Describe the current behavior** and **expected behavior**
- **Explain why this enhancement would be useful**

### Pull Requests

- Fork the repository
- Create a new branch for your feature/fix (`git checkout -b feature/amazing-feature`)
- Make your changes
- Write or update tests as needed
- Ensure code follows the project's style guidelines
- Commit your changes with clear, descriptive messages
- Push to your fork
- Open a Pull Request with a clear description of the changes

#### Pull Request Process

1. Ensure all tests pass: `composer test`
2. Update documentation with any new or changed functionality
3. Add an entry to [CHANGELOG.md](CHANGELOG.md) under an "Unreleased" section
4. Your PR will be reviewed by maintainers
5. Address any feedback or requested changes
6. Once approved, your PR will be merged

## Development Setup

### Prerequisites

- PHP 8.0 or higher
- Composer
- Git

### Installation

```bash
# Clone the repository
git clone https://github.com/warrenfox002/reach-interactive-sms-api.git

# Install dependencies
composer install

# Run tests
composer test

# Check code style
composer cs-check

# Fix code style issues
composer cs-fix
```

## Coding Standards

This project follows PSR-12 coding standards. Use the following commands to check and fix code style:

```bash
# Check code style
./vendor/bin/phpcs --standard=PSR12 src/

# Fix code style
./vendor/bin/phpcbf --standard=PSR12 src/
```

## Testing

Please write tests for any new features or bug fixes:

```bash
./vendor/bin/phpunit
```

## Documentation

- Update relevant documentation files when making changes
- Include PHPDoc comments for all public methods
- Provide clear, practical examples in code comments
- Update README.md with new features or significant changes

## Commit Messages

- Use the present tense ("Add feature" not "Added feature")
- Use the imperative mood ("Move cursor to..." not "Moves cursor to...")
- Limit the first line to 72 characters or less
- Reference issues and pull requests liberally after the first line

Example:
```
Add support for Unicode SMS messages

- Implement coding parameter validation
- Add unit tests for Unicode messages
- Update documentation

Fixes #123
```

## License

By contributing to this project, you agree that your contributions will be licensed under its MIT License.

## Questions?

Feel free to open an issue with the `question` label or contact the maintainers directly.

Thank you for your contributions!
