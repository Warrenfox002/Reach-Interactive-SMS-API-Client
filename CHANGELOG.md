# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.0.0] - 2024-06-15

### Added
- Initial release of Reach Interactive SMS API PHP Client
- Support for sending SMS messages (single and bulk)
- Account balance checking
- Message status retrieval
- Message deletion for scheduled messages
- Basic authentication via username and password
- JWT token authentication support
- Comprehensive exception handling with typed exceptions
- Delivery report callback support
- Full PSR-4 autoloading support
- Complete documentation and examples

### Features
- Send SMS to single or multiple recipients (up to 50 per request)
- Schedule messages for future delivery
- Custom message references for tracking
- Message coding support (Text, Unicode, Binary)
- Request timeout configuration
- SSL/TLS verification
- Proper error handling with HTTP status code mapping
- Type hints and strict types declaration

### Exceptions
- `ReachInteractiveException` - Base exception
- `ReachInteractiveAuthenticationException` - 401 Unauthorized
- `ReachInteractiveInsufficientCreditsException` - 402 Payment Required
- `ReachInteractiveBadRequestException` - 400 Bad Request
- `ReachInteractiveForbiddenException` - 403 Forbidden
- `ReachInteractiveServiceException` - 500 Server Error
- `ReachInteractiveUnavailableException` - 503 Service Unavailable
