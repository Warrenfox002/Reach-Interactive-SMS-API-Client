# Reach Interactive SMS API PHP Client

[![Latest Stable Version](https://img.shields.io/packagist/v/WarrenFox002/reach-interactive-sms-api.svg?style=flat-square)](https://packagist.org/packages/WarrenFox002/reach-interactive-sms-api)
[![Total Downloads](https://img.shields.io/packagist/dt/WarrenFox002/reach-interactive-sms-api.svg?style=flat-square)](https://packagist.org/packages/WarrenFox002/reach-interactive-sms-api)
[![License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
[![PHP Version](https://img.shields.io/badge/php-%3E%3D8.0-8892BF.svg?style=flat-square)](https://packagist.org/packages/WarrenFox002/reach-interactive-sms-api)

A comprehensive and easy-to-use PHP client library for the [Reach Interactive SMS API](https://www.reach-interactive.com/sms-api/api). Send SMS messages, check account balance, manage scheduled messages, and handle errors with typed exceptions.

## Features

✅ Full SMS API implementation  
✅ Typed exception handling for all error scenarios  
✅ JWT token authentication support  
✅ Basic authentication via username/password  
✅ Send single or bulk SMS messages (up to 50 per request)  
✅ Retrieve message status and details  
✅ Delete scheduled messages  
✅ Check account balance  
✅ Delivery report callbacks  
✅ Comprehensive error handling  
✅ PSR-4 autoloading  
✅ PHP 8.0+  

## Installation

Install via Composer:

```bash
composer require warrenfox002/reach-interactive-sms-api
```

## Quick Start

### Basic Usage

```php
use ReachInteractive\ReachInteractiveAPI;
use ReachInteractive\Exceptions\ReachInteractiveException;

// Initialize the API client
$api = new ReachInteractiveAPI('your_username', 'your_password');

try {
    // Send a message
    $result = $api->sendMessage(
        to: '447xxxxxxxxx',
        from: 'YourSender',
        message: 'Hello! This is a test message.'
    );
    
    echo "Message ID: " . $result[0]['Id'];
} catch (ReachInteractiveException $e) {
    echo "Error: " . $e->getMessage();
}
```

### Check Account Balance

```php
try {
    $balance = $api->getBalance();
    echo "Balance: " . $balance['Balance'];
} catch (ReachInteractiveException $e) {
    echo "Error: " . $e->getMessage();
}
```

### Send to Multiple Recipients

```php
$phones = ['447xxxxxxxxx', '447yyyyyyyyy', '447zzzzzzzzz'];

$result = $api->sendMessage(
    to: $phones,
    from: 'YourSender',
    message: 'Bulk message'
);

echo "Sent to " . count($result) . " recipients";
```

### Advanced Options

```php
$result = $api->sendMessage(
    to: '447xxxxxxxxx',
    from: 'YourSender',
    message: 'Scheduled message',
    options: [
        'reference' => 'ORDER-12345',
        'valid' => 24,  // Retry for 24 hours
        'scheduled' => '2024/06/20 14:30',
        'callbackurl' => 'https://yourdomain.com/sms-callback',
        'coding' => 1  // 1=Text, 2=Unicode, 3=Binary
    ]
);
```

## Exception Handling

The library provides specific exception types for different error scenarios:

```php
use ReachInteractive\ReachInteractiveAPI;
use ReachInteractive\Exceptions\{
    ReachInteractiveException,
    ReachInteractiveAuthenticationException,
    ReachInteractiveInsufficientCreditsException,
    ReachInteractiveBadRequestException,
    ReachInteractiveServiceException
};

try {
    $result = $api->sendMessage(
        to: '447xxxxxxxxx',
        from: 'YourSender',
        message: 'Test'
    );
} catch (ReachInteractiveAuthenticationException $e) {
    // Handle authentication error (401)
    echo "Invalid credentials";
} catch (ReachInteractiveInsufficientCreditsException $e) {
    // Handle credit error (402)
    echo "Out of credits";
} catch (ReachInteractiveBadRequestException $e) {
    // Handle validation error (400)
    echo "Invalid parameters";
} catch (ReachInteractiveServiceException $e) {
    // Handle service error (5xx)
    echo "Service error";
} catch (ReachInteractiveException $e) {
    // Handle all other errors
    echo "API error: " . $e->getMessage();
}
```

## Available Methods

### `getBalance(): array`
Retrieve your account balance and credit information.

```php
$balance = $api->getBalance();
// Returns: ['Success' => true, 'Balance' => 123.45, 'Description' => '...']
```

### `sendMessage(string|array $to, string $from, string $message, array $options = []): array`
Send SMS message(s) to one or more recipients.

```php
$result = $api->sendMessage(
    to: '447xxxxxxxxx',  // or array of numbers
    from: 'YourSender',
    message: 'Your message',
    options: [
        'reference' => 'custom-ref',
        'valid' => 72,
        'scheduled' => '2024/06/20 14:30',
        'callbackurl' => 'https://yourdomain.com/callback',
        'coding' => 1
    ]
);
```

### `getMessageDetails(string $messageId): array`
Get details about a previously sent message.

```php
$details = $api->getMessageDetails('message-uuid');
```

### `deleteMessage(string $messageId): array`
Delete a scheduled message that hasn't been sent yet.

```php
$result = $api->deleteMessage('message-uuid');
```

### `generateJWTToken(int $expiresMinutes = 60): string`
Generate a JWT token for authentication (alternative to basic auth).

```php
$token = $api->generateJWTToken(expiresMinutes: 60);
// Subsequent requests automatically use JWT authentication
```

### `isJWTTokenValid(): bool`
Check if the current JWT token is still valid.

```php
if ($api->isJWTTokenValid()) {
    echo "JWT token is valid";
}
```

### `setRequestTimeout(int $seconds): void`
Set custom timeout for API requests (default: 30 seconds).

```php
$api->setRequestTimeout(60);
```

## Error Codes

The API uses standard HTTP status codes:

| Code | Status | Exception |
|------|--------|-----------|
| 200 | OK | - |
| 400 | Bad Request | `ReachInteractiveBadRequestException` |
| 401 | Unauthorized | `ReachInteractiveAuthenticationException` |
| 402 | Payment Required | `ReachInteractiveInsufficientCreditsException` |
| 403 | Forbidden | `ReachInteractiveForbiddenException` |
| 500 | Server Error | `ReachInteractiveServiceException` |
| 503 | Service Unavailable | `ReachInteractiveUnavailableException` |

## DLR Codes (Delivery Reports)

| Code | Status |
|------|--------|
| 000 | Delivered |
| 600 | No credits to send |
| 601 | No route |
| 602 | Blacklisted number detected |
| 603 | Bad destination number |
| 604 | Bad source number |
| 605 | Target SMSC message queue |
| 606 | Target SMSC submit fail |
| 607 | General error |
| 608 | Spam message detected |
| 609 | Validity period expired |
| 610 | Unauthorised Source address |
| 611 | Unknown DLR code |
| 612 | Submit timeout |

## Delivery Reports

Configure callback URL to receive delivery reports:

```php
$api->sendMessage(
    to: '447xxxxxxxxx',
    from: 'YourSender',
    message: 'Message',
    options: [
        'callbackurl' => 'https://yourdomain.com/sms-callback'
    ]
);
```

The callback will receive GET requests with parameters:
- `MsgId`: Message ID
- `MSISDN`: Recipient number
- `Timestamp`: Delivery timestamp
- `Status`: Status (delivered, rejected, expired, undelivered)
- `Code`: DLR code

## Configuration

### Authentication

**Basic Auth (Default)**
```php
$api = new ReachInteractiveAPI('username', 'password');
```

**JWT Token Auth**
```php
$api = new ReachInteractiveAPI('username', 'password');
$token = $api->generateJWTToken(expiresMinutes: 120);
```

### Request Timeout

```php
$api->setRequestTimeout(60); // 60 seconds
```

## Requirements

- PHP 8.0 or higher
- cURL extension
- JSON extension

## Best Practices

1. **Always handle exceptions** - API calls can fail for various reasons
2. **Use JWT tokens** - More secure than basic auth for production
3. **Implement retry logic** - Handle 503 Service Unavailable errors gracefully
4. **Validate inputs** - Check phone numbers and message content before sending
5. **Log errors** - Keep detailed logs for troubleshooting and auditing
6. **Monitor balance** - Set up alerts for low credit balance
7. **Batch operations** - Use bulk sending (up to 50 recipients per request)
8. **Test first** - Send test messages before bulk operations

## Example Integration

```php
<?php

namespace App\Services;

use ReachInteractive\ReachInteractiveAPI;
use ReachInteractive\Exceptions\ReachInteractiveException;

class SMSService
{
    private ReachInteractiveAPI $api;

    public function __construct(string $username, string $password)
    {
        $this->api = new ReachInteractiveAPI($username, $password);
        $this->api->setRequestTimeout(60);
    }

    public function sendAlert(string $phoneNumber, string $message): bool
    {
        try {
            $result = $this->api->sendMessage(
                to: $phoneNumber,
                from: 'YourApp',
                message: $message,
                options: [
                    'reference' => uniqid('alert_'),
                    'valid' => 24
                ]
            );

            return $result[0]['Success'] ?? false;

        } catch (ReachInteractiveException $e) {
            error_log('SMS Error: ' . $e->getMessage());
            return false;
        }
    }
}
```

## Running Tests

```bash
composer install
./vendor/bin/phpunit
```

## Changelog

See [CHANGELOG.md](CHANGELOG.md) for version history.

## License

This library is licensed under the MIT License. See [LICENSE](LICENSE) file for details.

## Support

- **API Documentation:** https://www.reach-interactive.com/sms-api/api
- **Email:** sales@reach-data.com
- **Issues:** [GitHub Issues](https://github.com/WarrenFox002/reach-interactive-sms-api/issues)

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## Disclaimer

This is an unofficial client library for the Reach Interactive SMS API. It is not affiliated with or endorsed by Reach Interactive. Please refer to the official API documentation for the most up-to-date information.
