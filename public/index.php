<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Define PUBLIC_PATH untuk Opsi 2 deployment (isi public dikeluarkan ke root)
define('PUBLIC_PATH', __DIR__);

// Load custom helper SEBELUM vendor/autoload.php agar bisa override public_path()
// Ini penting agar public_path() mengarah ke root (public_html) bukan laravel/public
require_once __DIR__.'/laravel/app/helpers.php';

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/laravel/storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/laravel/vendor/autoload.php';

// Bootstrap Laravel and handle the request...
/** @var Application $app */
$app = require_once __DIR__.'/laravel/bootstrap/app.php';

$app->handleRequest(Request::capture());
