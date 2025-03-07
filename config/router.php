<?php

/*
 * Configuration required by the router service.
 *
 * For more information, see:
 * https://github.com/bayfrontmedia/route-it#start-using-route-it
 */

use Bayfront\Bones\Application\Utilities\App;

return [
    'host' => App::getEnv('ROUTER_HOST'), // Default host
    'route_prefix' => App::getEnv('ROUTER_ROUTE_PREFIX'), // Default route prefix
    'automapping_enabled' => false,
    'automapping_namespace' => 'App\\Controllers',
    'automapping_route_prefix' => App::getEnv('ROUTER_ROUTE_PREFIX'),
    //'class_namespace' => 'App\\Controllers', // Cannot be used with the API service
    'files_root_path' => App::resourcesPath('/views'),
    'force_lowercase_url' => true
];