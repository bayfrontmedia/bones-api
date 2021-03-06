<?php

return [
    'maintenance_mode' => false, // Boolean (optional)
    'maintenance_until' => new DateTime('2099-01-01 12:00:00'), // DateTimeInterface (optional)
    'allow_http' => 'development', // app.environments to allow http (string|array) (optional)
    'accept_header' => 'application/vnd.api+json', // Required Accept header (optional)
    'content_type' => 'application/vnd.api+json', // Required Content-Type header to exist with request body (optional)
    'allow_method_discovery' => true, // Automatically include the Accept header with all requests
    'buckets_path' => '/app/buckets', // Directory in which to store rate limit buckets from the default filesystem disk root
    'rate_limit_auth' => 5, // Per minute (Rate limit for failed authentication)

    // The following keys are unique to this application

    'rate_limit' => 50, // Per minute rate limit for authenticated user
    'rate_limit_public' => 100, // Per minute rate limit for public endpoints
    'access_token_lifetime' => 2592000, // 86400 (24 hours)
    'refresh_token_lifetime' => 604800, // e.g.: 604800 (7 days), 2592000 (30 days)
    'use_absolute_uri' => true, // Absolute vs relative URI's returned in schemas
    'default_page_size' => 10,
    'max_page_size' => 100
];