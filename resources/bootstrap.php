<?php /** @noinspection PhpUnhandledExceptionInspection */

/** @var Bayfront\Container\Container $container */

/*
 * This file is used to bootstrap the app, and is required by Bones.
 * Bootstrapping is primarily done by interacting with the service container
 * by adding all the required dependencies which will be used throughout the app,
 * and defining their alias, if desired.
 *
 * The service container is available in this file as $container, which already contains
 * all the default services.
 *
 * For more information, see:
 * https://github.com/bayfrontmedia/container#usage
 */

use Bayfront\Bones\Application\Utilities\App;
use Bayfront\BonesService\Api\ApiService;
use Bayfront\BonesService\Orm\OrmService;
use Bayfront\BonesService\Rbac\RbacService;
use Bayfront\LeakyBucket\Adapters\PDO;
use Bayfront\MonologPDO\PDOHandler;
use Bayfront\MultiLogger\ChannelName;
use Bayfront\MultiLogger\Log;
use Bayfront\SimplePdo\Db;
use Monolog\Logger;

/** @var Db $db */
$db = App::get('db');

/*
 * |--------------------------------------------------------------------------
 * | ORM service
 * |
 * | See: https://github.com/bayfrontmedia/bones-service-orm/blob/master/docs/setup.md#add-to-container
 * |--------------------------------------------------------------------------
 */

/** @var OrmService $ormService */
$ormService = $container->make('Bayfront\BonesService\Orm\OrmService', [
    'config' => (array)App::getConfig('orm', [])
]);

$container->set('Bayfront\BonesService\Orm\OrmService', $ormService);
$container->setAlias('ormService', 'Bayfront\BonesService\Orm\OrmService');

/*
 * |--------------------------------------------------------------------------
 * | RBAC service
 * |
 * | See: https://github.com/bayfrontmedia/bones-service-rbac/blob/master/docs/setup.md#add-to-container
 * |--------------------------------------------------------------------------
 */

/** @var RbacService $rbacService */
$rbacService = $container->make('Bayfront\BonesService\Rbac\RbacService', [
    'config' => (array)App::getConfig('rbac', [])
]);

$container->set('Bayfront\BonesService\Rbac\RbacService', $rbacService);
$container->setAlias('rbacService', 'Bayfront\BonesService\Rbac\RbacService');

/*
 * |--------------------------------------------------------------------------
 * | API service
 * |
 * | See: https://github.com/bayfrontmedia/bones-service-api/blob/master/docs/setup.md#add-to-container
 * |--------------------------------------------------------------------------
 */

$container->set('Bayfront\LeakyBucket\AdapterInterface', function () use ($db) {

    return new PDO($db->getCurrentConnection(), App::getConfig('app.buckets_table', 'api_buckets'));

});

/** @var ApiService $apiService */
$apiService = $container->make('Bayfront\BonesService\Api\ApiService', [
    'config' => (array)App::getConfig('api', [])
]);

$container->set('Bayfront\BonesService\Api\ApiService', $apiService);
$container->setAlias('apiService', 'Bayfront\BonesService\Api\ApiService');

/*
 * |--------------------------------------------------------------------------
 * | Multi-Logger
 * |
 * | See:
 * |   - https://github.com/bayfrontmedia/multi-logger
 * |   - https://github.com/bayfrontmedia/monolog-pdo
 * |--------------------------------------------------------------------------
 */

/*
 * The handler must be set in the container to be used by the
 * CreateLogsTable migration.
 */

$pdoHandler = new PDOHandler($db->getCurrentConnection(), App::getConfig('app.logs_table', 'logs'));

$container->set('Bayfront\MonologPDO\PDOHandler', $pdoHandler);

$container->set('Bayfront\MultiLogger\Log', function() use ($pdoHandler) {

    $system_channel = new Logger(ChannelName::SYSTEM);
    $system_channel->pushHandler($pdoHandler);

    $log = new Log($system_channel);

    $audit_channel = new Logger(ChannelName::AUDIT);
    $audit_channel->pushHandler($pdoHandler);

    $log->addChannel($audit_channel);

    return $log;

});

$container->setAlias('log', 'Bayfront\MultiLogger\Log');