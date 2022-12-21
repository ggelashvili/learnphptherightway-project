<?php

declare(strict_types=1);

use App\App;
use App\Config;
use App\Controllers\HomeController;
use App\Controllers\TransactionController;
use App\Controllers\UploadController;
use App\Router;

require_once __DIR__.'/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

define('STORAGE_PATH', __DIR__.'/../storage');
define('VIEW_PATH', __DIR__.'/../views');

session_start();

$router = new Router();

$router
    ->get('/', [HomeController::class, 'index'])
    ->post('/upload', [UploadController::class, 'upload'])
    ->get('/scan-files', [ScanAllFilesController::class, 'scanFiles'])
    ->get('/transactions', [TransactionController::class, 'index'])
    ->get('/transaction/delete', [TransactionController::class, 'delete'])
;

(new App(
    $router,
    ['uri' => $_SERVER['REQUEST_URI'], 'method' => $_SERVER['REQUEST_METHOD']],
    new Config($_ENV)
))->run();
