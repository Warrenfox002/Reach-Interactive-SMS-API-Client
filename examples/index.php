<?php

/**
 * Reach Interactive SMS API - Usage Examples
 *
 * This file demonstrates various ways to use the Reach Interactive SMS API client.
 */

require_once __DIR__ . '/../vendor/autoload.php';

use ReachInteractive\ReachInteractiveAPI;
use ReachInteractive\Exceptions\{
    ReachInteractiveException,
    ReachInteractiveAuthenticationException,
    ReachInteractiveInsufficientCreditsException,
    ReachInteractiveBadRequestException,
    ReachInteractiveServiceException,
    ReachInteractiveUnavailableException
};

// ========== Example 1: Basic Setup ==========
echo "=== Example 1: Basic Setup ===\n";

try {
    $api = new ReachInteractiveAPI('your_username', 'your_password');
    echo "✓ API client initialized successfully\n\n";
} catch (ReachInteractiveException $e) {
    echo "✗ Initialization error: " . $e->getMessage() . "\n\n";
}


// ========== Example 2: Check Account Balance ==========
echo "=== Example 2: Check Account Balance ===\n";

try {
    $balance = $api->getBalance();

    if ($balance['Success']) {
        echo "✓ Account Balance: {$balance['Balance']}\n";
        echo "  Description: {$balance['Description']}\n";
    } else {
        echo "✗ Failed to retrieve balance: {$balance['Description']}\n";
    }
    echo "\n";

} catch (ReachInteractiveAuthenticationException $e) {
    echo "✗ Authentication failed: " . $e->getMessage() . "\n\n";
} catch (ReachInteractiveServiceException $e) {
    echo "✗ Service error: " . $e->getMessage() . "\n\n";
} catch (ReachInteractiveException $e) {
    echo "✗ Error: " . $e->getMessage() . "\n\n";
}


// ========== Example 3: Send Single SMS ==========
echo "=== Example 3: Send Single SMS ===\n";

try {
    $result = $api->sendMessage(
        to: '447xxxxxxxxx',
        from: 'YourSender',
        message: 'Hello! This is a test message.'
    );

    foreach ($result as $msg) {
        if ($msg['Success']) {
            echo "✓ Message sent successfully\n";
            echo "  Message ID: {$msg['Id']}\n";
            echo "  Description: {$msg['Description']}\n";
        } else {
            echo "✗ Failed to send message: {$msg['Description']}\n";
        }
    }
    echo "\n";

} catch (ReachInteractiveBadRequestException $e) {
    echo "✗ Invalid request: " . $e->getMessage() . "\n\n";
} catch (ReachInteractiveInsufficientCreditsException $e) {
    echo "✗ Out of credits: " . $e->getMessage() . "\n\n";
} catch (ReachInteractiveException $e) {
    echo "✗ Error: " . $e->getMessage() . "\n\n";
}


// ========== Example 4: Send to Multiple Recipients ==========
echo "=== Example 4: Send to Multiple Recipients ===\n";

try {
    $phones = [
        '447xxxxxxxxx',
        '447yyyyyyyyy',
        '447zzzzzzzzz',
    ];

    $result = $api->sendMessage(
        to: $phones,
        from: 'YourSender',
        message: 'Bulk message to multiple recipients'
    );

    echo "✓ Sent to " . count($result) . " recipients\n";
    foreach ($result as $i => $msg) {
        echo "  [{$i}] ID: {$msg['Id']} - " . ($msg['Success'] ? 'Success' : 'Failed') . "\n";
    }
    echo "\n";

} catch (ReachInteractiveException $e) {
    echo "✗ Error: " . $e->getMessage() . "\n\n";
}


// ========== Example 5: Send with Optional Parameters ==========
echo "=== Example 5: Send with Optional Parameters ===\n";

try {
    $result = $api->sendMessage(
        to: '447xxxxxxxxx',
        from: 'YourSender',
        message: 'Message with advanced options',
        options: [
            'reference' => 'ORDER-12345',
            'valid' => 24,
            'scheduled' => date('Y/m/d H:i', strtotime('+1 hour')),
            'callbackurl' => 'https://yourdomain.com/sms-callback',
            'coding' => 1,
        ]
    );

    foreach ($result as $msg) {
        if ($msg['Success']) {
            echo "✓ Message scheduled successfully\n";
            echo "  Message ID: {$msg['Id']}\n";
        }
    }
    echo "\n";

} catch (ReachInteractiveBadRequestException $e) {
    echo "✗ Invalid parameters: " . $e->getMessage() . "\n\n";
} catch (ReachInteractiveException $e) {
    echo "✗ Error: " . $e->getMessage() . "\n\n";
}


// ========== Example 6: Get Message Details ==========
echo "=== Example 6: Get Message Details ===\n";

try {
    // Replace with an actual message ID from a previous send
    $messageId = 'aaaaaaaa-aaaa-aaaa-aaaa-aaaaaaaaaaaa';

    $details = $api->getMessageDetails($messageId);

    foreach ($details as $msg) {
        echo "✓ Message Details:\n";
        echo "  To: {$msg['To']}\n";
        echo "  From: {$msg['Originator']}\n";
        echo "  Status: {$msg['Message Status']}\n";
        echo "  DLR Code: {$msg['DlrCode']}\n";
        echo "  Sent: {$msg['Sent Date']}\n";
        if (!empty($msg['Delivered Date'])) {
            echo "  Delivered: {$msg['Delivered Date']}\n";
        }
    }
    echo "\n";

} catch (ReachInteractiveBadRequestException $e) {
    echo "✗ Invalid message ID: " . $e->getMessage() . "\n\n";
} catch (ReachInteractiveException $e) {
    echo "✗ Error: " . $e->getMessage() . "\n\n";
}


// ========== Example 7: Delete Scheduled Message ==========
echo "=== Example 7: Delete Scheduled Message ===\n";

try {
    // Replace with an actual message ID
    $messageId = 'aaaaaaaa-aaaa-aaaa-aaaa-aaaaaaaaaaaa';

    $result = $api->deleteMessage($messageId);

    if ($result['Success']) {
        echo "✓ Message deleted successfully\n";
        echo "  " . $result['Description'] . "\n";
    }
    echo "\n";

} catch (ReachInteractiveBadRequestException $e) {
    echo "✗ Invalid message ID: " . $e->getMessage() . "\n\n";
} catch (ReachInteractiveException $e) {
    echo "✗ Error: " . $e->getMessage() . "\n\n";
}


// ========== Example 8: Using JWT Authentication ==========
echo "=== Example 8: JWT Authentication ===\n";

try {
    $api = new ReachInteractiveAPI('your_username', 'your_password');

    // Generate JWT token valid for 120 minutes
    $token = $api->generateJWTToken(expiresMinutes: 120);
    echo "✓ JWT token generated successfully\n";

    // Check if token is valid
    if ($api->isJWTTokenValid()) {
        echo "✓ JWT token is valid\n";
    }

    // Use API with JWT (automatic from now on)
    $balance = $api->getBalance();
    echo "✓ Retrieved balance using JWT authentication\n";
    echo "  Balance: {$balance['Balance']}\n";
    echo "\n";

} catch (ReachInteractiveAuthenticationException $e) {
    echo "✗ JWT generation failed: " . $e->getMessage() . "\n\n";
} catch (ReachInteractiveException $e) {
    echo "✗ Error: " . $e->getMessage() . "\n\n";
}


// ========== Example 9: Comprehensive Error Handling ==========
echo "=== Example 9: Comprehensive Error Handling ===\n";

try {
    $api = new ReachInteractiveAPI('your_username', 'your_password');

    $result = $api->sendMessage(
        to: '447xxxxxxxxx',
        from: 'YourSender',
        message: 'Test message'
    );

    echo "✓ Message sent: {$result[0]['Id']}\n";

} catch (ReachInteractiveAuthenticationException $e) {
    echo "✗ Authentication Error (401): Please check your API credentials\n";
    error_log("Auth error: " . $e->getMessage());

} catch (ReachInteractiveInsufficientCreditsException $e) {
    echo "✗ Credit Error (402): Please add credits to your account\n";
    error_log("Credits error: " . $e->getMessage());

} catch (ReachInteractiveBadRequestException $e) {
    echo "✗ Validation Error (400): Check your input parameters\n";
    error_log("Validation error: " . $e->getMessage());

} catch (ReachInteractiveUnavailableException $e) {
    echo "✗ Service Unavailable (503): Service temporarily down, please retry later\n";
    error_log("Service unavailable: " . $e->getMessage());

} catch (ReachInteractiveServiceException $e) {
    echo "✗ Service Error (500): Internal server error\n";
    error_log("Service error: " . $e->getMessage());

} catch (ReachInteractiveException $e) {
    echo "✗ API Error: " . $e->getMessage() . "\n";
    error_log("General error: " . $e->getMessage());
}
echo "\n";


// ========== Example 10: Custom Request Timeout ==========
echo "=== Example 10: Custom Request Timeout ===\n";

try {
    $api = new ReachInteractiveAPI('your_username', 'your_password');
    $api->setRequestTimeout(60); // 60 seconds

    $balance = $api->getBalance();
    echo "✓ Retrieved balance with custom timeout (60s)\n";
    echo "  Balance: {$balance['Balance']}\n";
    echo "\n";

} catch (ReachInteractiveException $e) {
    echo "✗ Error: " . $e->getMessage() . "\n\n";
}


// ========== Example 11: Real-world Service Class ==========
echo "=== Example 11: Real-world Service Class ===\n";

class SMSService
{
    private ReachInteractiveAPI $api;

    public function __construct(string $username, string $password)
    {
        $this->api = new ReachInteractiveAPI($username, $password);
        $this->api->setRequestTimeout(60);
    }

    /**
     * Send an alert SMS
     */
    public function sendAlert(string $phoneNumber, string $message): bool
    {
        try {
            // Check balance first
            $balance = $this->api->getBalance();
            if (!$balance['Success']) {
                throw new Exception("Unable to check balance");
            }

            if ($balance['Balance'] < 1) {
                error_log("Insufficient balance to send alert");
                return false;
            }

            // Send message
            $result = $this->api->sendMessage(
                to: $phoneNumber,
                from: 'YourApp',
                message: $message,
                options: [
                    'reference' => uniqid('alert_'),
                    'valid' => 24,
                ]
            );

            return $result[0]['Success'] ?? false;

        } catch (ReachInteractiveInsufficientCreditsException $e) {
            error_log("SMS Error: Out of credits");
            return false;
        } catch (ReachInteractiveException $e) {
            error_log("SMS Error: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            error_log("Unexpected error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Send bulk SMS
     */
    public function sendBulk(array $phoneNumbers, string $message): array
    {
        $sent = [];
        $failed = [];

        // Process in chunks of 50 (API limit)
        $chunks = array_chunk($phoneNumbers, 50);

        foreach ($chunks as $chunk) {
            try {
                $result = $this->api->sendMessage(
                    to: $chunk,
                    from: 'YourApp',
                    message: $message,
                    options: [
                        'reference' => uniqid('bulk_'),
                    ]
                );

                foreach ($result as $item) {
                    if ($item['Success']) {
                        $sent[] = $item['Id'];
                    } else {
                        $failed[] = $item['Description'];
                    }
                }
            } catch (ReachInteractiveException $e) {
                error_log("Bulk send error: " . $e->getMessage());
                foreach ($chunk as $number) {
                    $failed[] = "Failed to send to $number: " . $e->getMessage();
                }
            }
        }

        return [
            'sent' => count($sent),
            'failed' => count($failed),
            'messageIds' => $sent,
            'errors' => $failed,
        ];
    }
}

// Usage
try {
    $smsService = new SMSService('your_username', 'your_password');

    // Send single alert
    $success = $smsService->sendAlert('447xxxxxxxxx', 'System alert!');
    echo ($success ? '✓' : '✗') . " Alert sent\n";

    // Send bulk messages
    $numbers = ['447xxxxxxxxx', '447yyyyyyyyy', '447zzzzzzzzz'];
    $result = $smsService->sendBulk($numbers, 'Bulk message');
    echo "✓ Bulk send complete: {$result['sent']} sent, {$result['failed']} failed\n";

} catch (Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
}
