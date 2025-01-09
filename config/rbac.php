<?php

/*
 * Configuration required by the RBAC service.
 */

use Bayfront\Bones\Application\Utilities\App;

return [
    'table_prefix' => 'rbac_', // RBAC database table prefix
    'protected_prefix' => '_app-', // Protected column prefix
    'invitation_duration' => 10080, // Max tenant invitation duration (in minutes), 0 for unlimited: 10080 = 7 days
    'user' => [
        'require_verification' => true, // Require users to be verified to authenticate
        'key' => [
            'max_mins' => 525600, // Max user key duration (in minutes), 0 for unlimited: 525600 = 365 days
        ],
        'token' => [
            'revocable' => true, // Allow access tokens to be revocable? This requires a database query to validate each request
            'access_duration' => App::environment() == App::ENV_DEV ? 10080 : 15, // Access token duration (in minutes)
            'refresh_duration' => 10080, // Refresh token duration (in minutes): 10080 = 7 days
        ]
    ],
    'model' => [ // Override ORM service resource configuration per-model (optional)
        'permissions' => [
            'default_limit' => 100,
            'max_limit' => -1,
            'max_related_depth' => 3,
        ],
        'tenant_invitations' => [
            'default_limit' => 100,
            'max_limit' => -1,
            'max_related_depth' => 3,
        ],
        'tenant_meta' => [
            'default_limit' => 100,
            'max_limit' => -1,
            'max_related_depth' => 3,
        ],
        'tenant_permissions' => [
            'default_limit' => 100,
            'max_limit' => -1,
            'max_related_depth' => 3,
        ],
        'tenant_role_permissions' => [
            'default_limit' => 100,
            'max_limit' => -1,
            'max_related_depth' => 3,
        ],
        'tenant_roles' => [
            'default_limit' => 100,
            'max_limit' => -1,
            'max_related_depth' => 3,
        ],
        'tenants' => [
            'default_limit' => 100,
            'max_limit' => -1,
            'max_related_depth' => 3,
        ],
        'tenant_teams' => [
            'default_limit' => 100,
            'max_limit' => -1,
            'max_related_depth' => 3,
        ],
        'tenant_user_meta' => [
            'default_limit' => 100,
            'max_limit' => -1,
            'max_related_depth' => 3,
        ],
        'tenant_user_roles' => [
            'default_limit' => 100,
            'max_limit' => -1,
            'max_related_depth' => 3,
        ],
        'tenant_user_teams' => [
            'default_limit' => 100,
            'max_limit' => -1,
            'max_related_depth' => 3,
        ],
        'tenant_users' => [
            'default_limit' => 100,
            'max_limit' => -1,
            'max_related_depth' => 3,
        ],
        'user_keys' => [
            'default_limit' => 100,
            'max_limit' => -1,
            'max_related_depth' => 3,
        ],
        'user_meta' => [
            'default_limit' => 100,
            'max_limit' => -1,
            'max_related_depth' => 3,
        ],
        'users' => [
            'default_limit' => 100,
            'max_limit' => -1,
            'max_related_depth' => 3,
        ]
    ]
];