<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Detect Vercel/serverless environment
$_ENV['VERCEL'] = true;
$_ENV['APP_STORAGE'] = '/tmp/storage';
$_ENV['VIEW_COMPILED_PATH'] = '/tmp/storage/framework/views';

// Create necessary directories in /tmp (writable in serverless)
$directories = [
    '/tmp/storage',
    '/tmp/storage/framework',
    '/tmp/storage/framework/cache',
    '/tmp/storage/framework/cache/data',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/framework/views',
    '/tmp/storage/logs',
    '/tmp/bootstrap',
    '/tmp/bootstrap/cache',
];

foreach ($directories as $dir) {
    if (!is_dir($dir)) {
        @mkdir($dir, 0755, true);
    }
}

// Copy bootstrap cache files if they exist
$bootstrapCacheFiles = [
    __DIR__.'/../bootstrap/cache/packages.php',
    __DIR__.'/../bootstrap/cache/services.php',
];

foreach ($bootstrapCacheFiles as $file) {
    if (file_exists($file)) {
        $targetFile = '/tmp/bootstrap/cache/' . basename($file);
        if (!file_exists($targetFile)) {
            @copy($file, $targetFile);
        }
    }
}

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/../vendor/autoload.php';

// Bootstrap Laravel and handle the request...
/** @var Application $app */
$app = require_once __DIR__.'/../bootstrap/app.php';

// Override storage paths for serverless environment
$app->useStoragePath($_ENV['APP_STORAGE']);
$app->useBootstrapPath('/tmp/bootstrap');

$app->handleRequest(Request::capture());
