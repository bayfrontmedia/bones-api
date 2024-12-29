<?php /** @noinspection PhpUnhandledExceptionInspection */

use Bayfront\Bones\Application\Utilities\App;
use Bayfront\Bones\Bones;
use Bayfront\Bones\BonesConstructor;

// -------------------- Use Composer's autoloader --------------------

require __DIR__ . '/../vendor/autoload.php';

// -------------------- Start app --------------------

$base_path = $_ENV['APP_BASE_PATH'] ?? dirname(__DIR__);
$public_path = $_ENV['APP_PUBLIC_PATH'] ?? $base_path . '/public';

$bones = new Bones(new BonesConstructor([
    'base_path' => $base_path,
    'public_path' => $public_path
]));

$bones->start(App::INTERFACE_HTTP);
