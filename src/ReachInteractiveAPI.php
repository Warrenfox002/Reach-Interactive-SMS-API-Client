<?php

declare(strict_types=1);

namespace ReachInteractive;

use ReachInteractive\Exceptions\{
    ReachInteractiveException,
    ReachInteractiveAuthenticationException,
    ReachInteractiveInsufficientCreditsException,
    ReachInteractiveBadRequestException,
    ReachInteractiveForbiddenException,
    ReachInteractiveServiceException,
    ReachInteractiveUnavailableException
};

/**
 * Reach Interactive SMS API Client
 *
 * A comprehensive PHP client for interacting with the Reach Interactive SMS API
 * Documentation: https://www.reach-interactive.com/sms-api/api
 */
class ReachInteractiveAPI
{
    private const BASE_URL = 'https://api.reach-interactive.com';
    private const JWT_BASE_URL = 'https://http-10.reach-interactive.com';

    private string $username;
    private string $password;
    private ?string $jwtToken = null;
    private int $jwtExpiresAt = 0;
    private int $requestTimeout = 30;

    /**
     * Constructor
     *
     * @param string $username Your Reach Interactive API Username
     * @param string $password Your Reach Interactive API Password
     * @throws ReachInteractiveException
     */
    public function __construct(string $username, string $password)
    {
        if (empty($username) || empty($password)) {
            throw new ReachInteractiveException('Username and password are required');
        }

        $this->username = $username;
        $this->password = $password;
    }

    /**
     * Generate JWT token for authentication
     *
     * @param int $expiresMinutes Token expiration time in minutes (10-44640)
     * @return string JWT Token
     *
     * @throws ReachInteractiveAuthenticationException
     * @throws ReachInteractiveServiceException
     * @throws ReachInteractiveException
     */
    public function generateJWTToken(int $expiresMinutes = 60): string
    {
        if ($expiresMinutes < 10 || $expiresMinutes > 44640) {
            throw new ReachInteractiveException('Token expiration must be between 10 and 44640 minutes');
        }

        $payload = [
            'username' => $this->username,
            'password' => $this->password,
            'expiresMinutes' => $expiresMinutes,
        ];

        try {
            $response = $this->makeRequest('POST', self::JWT_BASE_URL . '/Auth/Login', $payload, useAuth: false);

            if (isset($response['token'])) {
                $this->jwtToken = $response['token'];
                $this->jwtExpiresAt = time() + ($expiresMinutes * 60);
                return $this->jwtToken;
            }

            throw new ReachInteractiveException('Failed to generate JWT token');
        } catch (ReachInteractiveException $e) {
            throw $e;
        }
    }

    /**
     * Check if JWT token is still valid
     *
     * @return bool
     */
    public function isJWTTokenValid(): bool
    {
        return $this->jwtToken !== null && time() < $this->jwtExpiresAt;
    }

    /**
     * Get account balance
     *
     * @return array Balance information with keys: Success, Balance, Description
     *
     * @throws ReachInteractiveAuthenticationException
     * @throws ReachInteractiveForbiddenException
     * @throws ReachInteractiveServiceException
     * @throws ReachInteractiveException
     */
    public function getBalance(): array
    {
        return $this->makeRequest('GET', self::BASE_URL . '/sms/balance');
    }

    /**
     * Send SMS message(s)
     *
     * @param string|array $to Phone number(s) - single number or array of numbers
     * @param string $from Sender ID/originator
     * @param string $message Message content (max 160 chars for single SMS)
     * @param array $options Optional parameters:
     *   - valid: int|float Hours to retry (min 0.25, default 72)
     *   - reference: string Custom reference
     *   - callbackurl: string URL for delivery reports
     *   - scheduled: string Send time (yyyy/MM/dd hh:mm)
     *   - coding: int Message type (1=Text, 2=Unicode, 3=Binary, default 1)
     *   - udh: string User Data Header
     *
     * @return array Array of message objects with keys: Success, Id, Description
     *
     * @throws ReachInteractiveBadRequestException
     * @throws ReachInteractiveAuthenticationException
     * @throws ReachInteractiveInsufficientCreditsException
     * @throws ReachInteractiveForbiddenException
     * @throws ReachInteractiveServiceException
     * @throws ReachInteractiveException
     */
    public function sendMessage(
        string|array $to,
        string $from,
        string $message,
        array $options = []
    ): array {
        if (empty($to) || empty($from) || empty($message)) {
            throw new ReachInteractiveBadRequestException('To, From, and Message are required parameters');
        }

        // Normalize phone numbers
        $toNumbers = is_array($to) ? $to : [$to];

        if (count($toNumbers) > 50) {
            throw new ReachInteractiveBadRequestException('Maximum 50 recipients per request');
        }

        $payload = [
            'to' => implode(',', $toNumbers),
            'from' => $from,
            'message' => $message,
        ];

        // Add optional parameters
        if (isset($options['valid'])) {
            if ($options['valid'] < 0.25) {
                throw new ReachInteractiveBadRequestException('Valid parameter must be at least 0.25 hours');
            }
            $payload['valid'] = $options['valid'];
        }

        if (isset($options['reference'])) {
            $payload['reference'] = $options['reference'];
        }

        if (isset($options['callbackurl'])) {
            $payload['callbackurl'] = $options['callbackurl'];
        }

        if (isset($options['scheduled'])) {
            $payload['scheduled'] = $options['scheduled'];
        }

        if (isset($options['coding'])) {
            if (!in_array($options['coding'], [1, 2, 3])) {
                throw new ReachInteractiveBadRequestException('Coding must be 1 (Text), 2 (Unicode), or 3 (Binary)');
            }
            $payload['coding'] = $options['coding'];
        }

        if (isset($options['udh'])) {
            $payload['udh'] = $options['udh'];
        }

        return $this->makeRequest('POST', self::BASE_URL . '/sms/message', $payload);
    }

    /**
     * Get message details
     *
     * @param string $messageId Message ID returned from sendMessage
     * @return array Array with message details
     *
     * @throws ReachInteractiveBadRequestException
     * @throws ReachInteractiveAuthenticationException
     * @throws ReachInteractiveForbiddenException
     * @throws ReachInteractiveServiceException
     * @throws ReachInteractiveException
     */
    public function getMessageDetails(string $messageId): array
    {
        if (empty($messageId)) {
            throw new ReachInteractiveBadRequestException('Message ID is required');
        }

        return $this->makeRequest('GET', self::BASE_URL . '/sms/message/' . urlencode($messageId));
    }

    /**
     * Delete a scheduled message that has not been sent
     *
     * @param string $messageId Message ID to delete
     * @return array Response with Success, Id, and Description
     *
     * @throws ReachInteractiveBadRequestException
     * @throws ReachInteractiveAuthenticationException
     * @throws ReachInteractiveForbiddenException
     * @throws ReachInteractiveServiceException
     * @throws ReachInteractiveException
     */
    public function deleteMessage(string $messageId): array
    {
        if (empty($messageId)) {
            throw new ReachInteractiveBadRequestException('Message ID is required');
        }

        return $this->makeRequest('DELETE', self::BASE_URL . '/sms/message/' . urlencode($messageId));
    }

    /**
     * Make HTTP request to API
     *
     * @param string $method HTTP method (GET, POST, DELETE)
     * @param string $url Full URL
     * @param array $data Request payload for POST/DELETE
     * @param bool $useAuth Whether to use authentication headers
     * @return array Decoded JSON response
     *
     * @throws ReachInteractiveBadRequestException
     * @throws ReachInteractiveAuthenticationException
     * @throws ReachInteractiveInsufficientCreditsException
     * @throws ReachInteractiveForbiddenException
     * @throws ReachInteractiveServiceException
     * @throws ReachInteractiveUnavailableException
     * @throws ReachInteractiveException
     */
    private function makeRequest(
        string $method,
        string $url,
        array $data = [],
        bool $useAuth = true
    ): array {
        if (!function_exists('curl_init')) {
            throw new ReachInteractiveException('cURL extension is required');
        }

        $curl = curl_init();

        try {
            curl_setopt_array($curl, [
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => $this->requestTimeout,
                CURLOPT_SSL_VERIFYPEER => true,
                CURLOPT_SSL_VERIFYHOST => 2,
                CURLOPT_CUSTOMREQUEST => $method,
                CURLOPT_HTTPHEADER => array_merge(
                    ['Content-Type: application/json'],
                    $this->getAuthHeaders()
                ),
            ]);

            if (!empty($data)) {
                curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
            }

            $response = curl_exec($curl);
            $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            $curlError = curl_error($curl);

            if ($curlError) {
                throw new ReachInteractiveException('cURL Error: ' . $curlError);
            }

            $decodedResponse = json_decode($response, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new ReachInteractiveException('Invalid JSON response: ' . json_last_error_msg());
            }

            $this->handleHttpStatusCode($httpCode, $decodedResponse);

            return $decodedResponse;

        } finally {
            curl_close($curl);
        }
    }

    /**
     * Get authentication headers
     *
     * @return array Headers array
     */
    private function getAuthHeaders(): array
    {
        if ($this->isJWTTokenValid()) {
            return ['Authorization: Bearer ' . $this->jwtToken];
        }

        return [
            'Username: ' . $this->username,
            'Password: ' . $this->password,
        ];
    }

    /**
     * Handle HTTP status codes and throw appropriate exceptions
     *
     * @param int $httpCode HTTP status code
     * @param array $response Decoded response body
     *
     * @throws ReachInteractiveBadRequestException
     * @throws ReachInteractiveAuthenticationException
     * @throws ReachInteractiveInsufficientCreditsException
     * @throws ReachInteractiveForbiddenException
     * @throws ReachInteractiveServiceException
     * @throws ReachInteractiveUnavailableException
     */
    private function handleHttpStatusCode(int $httpCode, array $response): void
    {
        $message = $response['Description'] ?? 'Unknown error occurred';

        switch ($httpCode) {
            case 200:
                return;

            case 400:
                throw new ReachInteractiveBadRequestException($message, 400);

            case 401:
                throw new ReachInteractiveAuthenticationException(
                    'Invalid authentication credentials: ' . $message,
                    401
                );

            case 402:
                throw new ReachInteractiveInsufficientCreditsException(
                    'Insufficient credits to send message: ' . $message,
                    402
                );

            case 403:
                throw new ReachInteractiveForbiddenException(
                    'Account forbidden for this action: ' . $message,
                    403
                );

            case 500:
                throw new ReachInteractiveServiceException(
                    'Service error: ' . $message,
                    500
                );

            case 503:
                throw new ReachInteractiveUnavailableException(
                    'Service unavailable: ' . $message,
                    503
                );

            default:
                throw new ReachInteractiveException(
                    'HTTP ' . $httpCode . ': ' . $message,
                    $httpCode
                );
        }
    }

    /**
     * Set request timeout in seconds
     *
     * @param int $seconds Timeout in seconds
     * @return void
     *
     * @throws ReachInteractiveException
     */
    public function setRequestTimeout(int $seconds): void
    {
        if ($seconds <= 0) {
            throw new ReachInteractiveException('Request timeout must be greater than 0');
        }
        $this->requestTimeout = $seconds;
    }
}
