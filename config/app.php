<?php

use Bayfront\Bones\Application\Utilities\App;

/*
 * Configuration required by Bones.
 */

return [
    'namespace' => 'App\\', // Namespace for the app/ directory, as specified in composer.json
    'key' => App::getEnv('APP_KEY'), // Unique to the app, not to the environment
    'debug' => App::getEnv('APP_DEBUG'),
    'environment' => App::getEnv('APP_ENVIRONMENT'), // e.g.: "dev", "staging", "qa", "prod"
    'timezone' => App::getEnv('APP_TIMEZONE'), // See: https://www.php.net/manual/en/timezones.php
    // Begin app-specific config
    'buckets_table' => 'buckets', // Buckets table name
    'logs_table' => 'logs', // Logs table name
    'slow_response_duration' => 1 // Elapsed duration (in seconds) to begin logging slow responses
];