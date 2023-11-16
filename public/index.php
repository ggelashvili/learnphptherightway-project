<?php

declare(strict_types = 1);

use App\App;
use App\Config;
use App\Controllers\TransactionController;
use App\Router;

define("ROOT", dirname(__DIR__));
define('STORAGE_PATH', ROOT . '/storage');
define('VIEW_PATH', ROOT . '/views');

require_once ROOT . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

$router = new Router();

$router
    ->get('/transactions', [TransactionController::class, 'index'])
    ->get('/transactions/create', [TransactionController::class, 'create'])
    ->post('/transactions/create', [TransactionController::class, 'store']);

(new App(
    $router,
    ['uri' => $_SERVER['REQUEST_URI'], 'method' => $_SERVER['REQUEST_METHOD']],
    new Config($_ENV)
))->run();
