<?php

// Define path constants
defined('YII_DEBUG') or define('YII_DEBUG', getenv('APP_DEBUG') === 'true');
defined('YII_ENV') or define('YII_ENV', getenv('APP_ENV') ?: 'prod');

// Load Composer autoloader
require __DIR__ . '/../vendor/autoload.php';

// Load Yii
require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';

// Load application config
$config = require __DIR__ . '/../config/web.php';

// Handle simple API routing
$request = $_SERVER['REQUEST_URI'] ?? '/';
$path = parse_url($request, PHP_URL_PATH);

// Simple API endpoints without full Yii2 routing
if ($path === '/api' || $path === '/api/') {
    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');
    
    echo json_encode([
        'status' => 'success',
        'message' => 'Welcome to the API',
        'timestamp' => date('Y-m-d H:i:s'),
        'endpoints' => [
            '/api' => 'API information',
            '/api/health' => 'Health check',
        ]
    ]);
    exit;
}

if ($path === '/api/health') {
    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');
    
    // Check database connection
    $dbStatus = 'unknown';
    try {
        $db = require __DIR__ . '/../config/db.php';
        $pdo = new PDO(
            $db['dsn'],
            $db['username'],
            $db['password']
        );
        $dbStatus = 'connected';
    } catch (Exception $e) {
        $dbStatus = 'error: ' . $e->getMessage();
    }
    
    echo json_encode([
        'status' => 'healthy',
        'database' => $dbStatus,
        'php_version' => PHP_VERSION,
        'timestamp' => date('Y-m-d H:i:s'),
    ]);
    exit;
}

// For other requests, use full Yii2 application
(new yii\web\Application($config))->run();
