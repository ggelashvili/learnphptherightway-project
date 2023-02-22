<?php

declare(strict_types = 1);

use App\App;
use App\Config;
use App\Controllers\UploadController;
use App\Router;

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

define('STORAGE_PATH', __DIR__ . '/../storage');
define('VIEW_PATH', __DIR__ . '/../views');

$router = new Router();

$router
    ->get('/', [UploadController::class, 'index'])
    ->post('/upload', [UploadController::class, 'upload'])
    ->get('/transactions', [UploadController::class, 'display']);

(new App(
    $router,
    ['uri' => $_SERVER['REQUEST_URI'], 'method' => $_SERVER['REQUEST_METHOD']],
    new Config($_ENV)
))->run();
