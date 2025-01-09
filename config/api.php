<?php

/*
 * Configuration required by the API service.
 */

use Bayfront\Bones\Application\Utilities\App;
use Bayfront\BonesService\Rbac\RbacService;

return [
    'version' => '1.0.0', // API version
    'request' => [
        'headers' => [ // Required headers for every request
            'Accept' => 'application/json',
        ],
        'https_env' => [ // App environments to force HTTPS
            App::ENV_STAGING,
            App::ENV_QA,
            App::ENV_PROD,
        ],
        'id' => [ // Unique request ID
            'enabled' => true,
            'length' => 10,
        ],
        'ip_whitelist' => [], // Only allow requests from IPs (empty array to allow all)
        'meta' => [ // Allow requests for meta array to be returned
            'enabled' => true,
            'field' => 'meta',
            'env' => [
                App::ENV_DEV,
                App::ENV_STAGING,
                App::ENV_QA,
                App::ENV_PROD,
            ],
        ],
    ],
    'response' => [
        'headers' => [ // Required headers for every response
            'Content-Type' => 'application/json',
        ],
    ],
    'rate_limit' => [ // Rate limit (per minute), 0 for unlimited
        'auth' => App::environment() === App::ENV_DEV ? 0 : 3,
        'private' => App::environment() === App::ENV_DEV ? 0 : 200,
        'public' => App::environment() === App::ENV_DEV ? 0 : 10,
    ],
    'identity' => [ // Allowed identification methods
        'key' => true, // API key
        'token' => true, // Access token
    ],
    'auth' => [ // Allowed authentication methods
        'password' => [ // Authenticate with email + password
            'enabled' => true,
            'tfa' => [
                'enabled' => !(App::environment() === App::ENV_DEV),
                'wait' => 3, // Wait time (in minutes) to wait before creating a new TFA, or 0 to disable
                'duration' => 15, // Validity duration (in minutes), 0 for unlimited
                'length' => 6, // Value length
                'type' => RbacService::TOTP_TYPE_NUMERIC, // Value type
            ],
        ],
        'otp' => [ // Authenticate with email + OTP
            'enabled' => true,
            'wait' => 3, // Wait time (in minutes) to wait before creating a new TFA, or 0 to disable
            'duration' => 15, // Validity duration (in minutes), 0 for unlimited
            'length' => 6, // Value length
            'type' => RbacService::TOTP_TYPE_NUMERIC, // Value type
        ],
        'refresh' => [ // Authenticate using refresh token
            'enabled' => true,
        ],
    ],
    'meta' => [ // Meta validation rules in dot notation, or empty for none. Only these keys will be allowed.
        'tenant' => [
            'address.street' => 'isString|lengthLessThan:255',
            'address.street2' => 'isString|lengthLessThan:255',
            'address.city' => 'isString|lengthLessThan:255',
            'address.state' => 'isString|lengthLessThan:255',
            'address.zip' => 'isString|lengthLessThan:255',
        ],
        'tenant_user' => [],
        'user' => [
            'name.first' => 'required|isString|lengthLessThan:255',
            'name.last' => 'required|isString|lengthLessThan:255',
            'name.full' => 'required|isString|lengthLessThan:255',
        ],
    ],
    'user' => [
        'allow_register' => false, // Allow public user registration?
        'allow_delete' => true, // Allow users to delete their own accounts?
        'unverified_expiration' => 10080, // If RBAC users require verification, duration before unverified users are deleted (in minutes), 0 for unlimited: 10080 = 7 days
        'password_request' => [ // Password reset request
            'enabled' => true,
            'wait' => 3,
            'duration' => 15,
            'length' => 36,
            'type' => RbacService::TOTP_TYPE_ALPHANUMERIC,
        ],
        'verification' => [ // User email verification
            'enabled' => true,
            'wait' => 3,
            'duration' => 1440,
            'length' => 36,
            'type' => RbacService::TOTP_TYPE_ALPHANUMERIC,
        ],
    ],
    'tenant' => [
        'allow_create' => false, // Allow non-admin users to create tenants?
        'auto_enabled' => true, // Enable tenants created by non-admin users?
        'allow_delete' => true, // Allow non-admin users to delete tenants they own?
        'user_meta' => [
            'manage_self' => true, // Allow tenant users to manage their own tenant_user_meta?
        ],
    ],
];