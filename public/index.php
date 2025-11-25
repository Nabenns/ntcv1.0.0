<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Deteksi apakah ini Opsi 2 deployment (ada folder laravel) atau local development
$isOpsi2 = is_dir(__DIR__.'/laravel') && file_exists(__DIR__.'/laravel/vendor/autoload.php');
$basePath = $isOpsi2 ? __DIR__.'/laravel' : dirname(__DIR__);

// Define PUBLIC_PATH untuk Opsi 2 deployment (isi public dikeluarkan ke root)
define('PUBLIC_PATH', __DIR__);

// Load custom helper SEBELUM vendor/autoload.php agar bisa override public_path()
// Ini penting agar public_path() mengarah ke root (public_html) bukan laravel/public
$helpersPath = $basePath.'/app/helpers.php';
if (file_exists($helpersPath)) {
    require_once $helpersPath;
}

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = $basePath.'/storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require $basePath.'/vendor/autoload.php';

// Bootstrap Laravel and handle the request...
/** @var Application $app */
$app = require_once $basePath.'/bootstrap/app.php';

$app->handleRequest(Request::capture());
