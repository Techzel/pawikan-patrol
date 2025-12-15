<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Detect Vercel/serverless environment
$_ENV['VERCEL'] = true;
$_ENV['APP_STORAGE'] = '/tmp/storage';
$_ENV['VIEW_COMPILED_PATH'] = '/tmp/storage/framework/views';

// Fallback to cookie session and file cache if no database is configured
if (empty($_ENV['DB_HOST'])) {
    $_ENV['SESSION_DRIVER'] = 'cookie';
    $_ENV['CACHE_STORE'] = 'file';
    $_ENV['LOG_CHANNEL'] = 'stderr';
}

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

// -----------------------------------------------------------------------------
// AUTOMATIC DATABASE FALLBACK (Ephemeral SQLite)
// -----------------------------------------------------------------------------
// If no external DB is configured, use a temporary SQLite database in /tmp
if (empty($_ENV['DB_HOST'])) {
    $dbPath = '/tmp/database.sqlite';
    
    // Configure environment to use SQLite
    $_ENV['DB_CONNECTION'] = 'sqlite';
    $_ENV['DB_DATABASE'] = $dbPath;
    $_ENV['DB_FOREIGN_KEYS'] = 'true';
    
    // Fallback drivers
    $_ENV['SESSION_DRIVER'] = 'cookie';
    $_ENV['CACHE_STORE'] = 'file';
    $_ENV['LOG_CHANNEL'] = 'stderr';

    // serverless-specific: ensure database exists and is migrated
    if (!file_exists($dbPath)) {
        touch($dbPath);
        
        // Run migrations only if we just created the DB
        // We use the kernel to run the command since $app is already created
        $kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
        
        // We need to temporarily force the environment variables for the artisan command
        putenv("DB_CONNECTION=sqlite");
        putenv("DB_DATABASE={$dbPath}");
        
        try {
            $kernel->call('migrate', ['--force' => true]);
        } catch (\Exception $e) {
            // Log migration error but continue (might be partial migration)
            error_log("Auto-migration failed: " . $e->getMessage());
        }
    }
}
// -----------------------------------------------------------------------------

$app->handleRequest(Request::capture());
