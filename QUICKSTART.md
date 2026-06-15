# Quick Start Guide

## Installation

Install the package via Composer:

```bash
composer require warrenfox002/reach-interactive-sms-api
```

## Basic Setup

### 1. Get Your API Credentials

1. Sign up for a free account at [Reach Interactive](https://www.reach-interactive.com/about-reach/create-your-free-account-today)
2. Log in to your account
3. Go to **Support > Developer > API Details**
4. Copy your API Username and Password

### 2. Initialize the Client

```php
<?php

require_once 'vendor/autoload.php';

use ReachInteractive\ReachInteractiveAPI;
use ReachInteractive\Exceptions\ReachInteractiveException;

// Create client instance
$api = new ReachInteractiveAPI('your_username', 'your_password');

try {
    // Check your account balance
    $balance = $api->getBalance();
    echo "Your balance: " . $balance['Balance'];
} catch (ReachInteractiveException $e) {
    echo "Error: " . $e->getMessage();
}
```

## Send Your First Message

```php
<?php

use ReachInteractive\ReachInteractiveAPI;

$api = new ReachInteractiveAPI('your_username', 'your_password');

try {
    // Send a single message
    $result = $api->sendMessage(
        to: '447xxxxxxxxx',      // Phone number
        from: 'YourSender',       // Sender ID
        message: 'Hello World!'   // Message text
    );
    
    echo "Message ID: " . $result[0]['Id'];
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
```

## Passing Credentials from Code

Pass your credentials directly when creating the API instance:

```php
use ReachInteractive\ReachInteractiveAPI;

$api = new ReachInteractiveAPI(
    username: 'your_username',
    password: 'your_password'
);
```

For production, store credentials securely and retrieve them from your configuration system:

```php
// Load from config file, environment, or secure storage
$credentials = getSecureCredentials();

$api = new ReachInteractiveAPI(
    username: $credentials['username'],
    password: $credentials['password']
);
```

## Common Tasks

### Check Account Balance

```php
$balance = $api->getBalance();
echo "Balance: " . $balance['Balance'];
```

### Send Bulk Messages

```php
$phones = ['447xxxxxxxxx', '447yyyyyyyyy', '447zzzzzzzzz'];

$result = $api->sendMessage(
    to: $phones,
    from: 'YourSender',
    message: 'Hello everyone!'
);

echo "Sent to " . count($result) . " recipients";
```

### Schedule a Message

```php
$result = $api->sendMessage(
    to: '447xxxxxxxxx',
    from: 'YourSender',
    message: 'Scheduled message',
    options: [
        'scheduled' => '2024/06/20 14:30'  // yyyy/MM/dd hh:mm
    ]
);
```

### Track Message Delivery

```php
$result = $api->sendMessage(
    to: '447xxxxxxxxx',
    from: 'YourSender',
    message: 'Message with tracking',
    options: [
        'reference' => 'ORDER-123',  // Custom reference
        'callbackurl' => 'https://yourdomain.com/sms-callback'
    ]
);

// Later, check the message status
$details = $api->getMessageDetails($result[0]['Id']);
echo "Status: " . $details[0]['Message Status'];
```

## Error Handling

The library throws specific exceptions for different error scenarios:

```php
use ReachInteractive\Exceptions\{
    ReachInteractiveException,
    ReachInteractiveAuthenticationException,
    ReachInteractiveInsufficientCreditsException,
    ReachInteractiveBadRequestException
};

try {
    $result = $api->sendMessage(...);
} catch (ReachInteractiveAuthenticationException $e) {
    // Handle authentication error
} catch (ReachInteractiveInsufficientCreditsException $e) {
    // Handle insufficient credits
} catch (ReachInteractiveBadRequestException $e) {
    // Handle invalid parameters
} catch (ReachInteractiveException $e) {
    // Handle other errors
}
```

## Examples

See the `examples/` directory for more comprehensive examples, including:

- Sending single and bulk messages
- Using optional parameters
- Handling different error scenarios
- JWT token authentication
- Creating a reusable SMS service class

## Documentation

Full documentation is available in [README.md](README.md)

## Support

- **API Documentation:** https://www.reach-interactive.com/sms-api/api
- **Issues:** https://github.com/warrenfox002/reach-interactive-sms-api/issues
- **Email:** sales@reach-data.com

## Next Steps

1. ✅ Install the package
2. ✅ Get your API credentials
3. ✅ Initialize the client
4. ✅ Send your first message
5. 📖 Read the full [documentation](README.md)
6. 🧪 Check out the [examples](examples/)
7. 🚀 Build something amazing!
