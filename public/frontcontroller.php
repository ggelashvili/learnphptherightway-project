<?php

declare(strict_types=1);

use App\App;
use App\Config;
use App\Router;
use App\Controllers\HomeController;
use App\Controllers\TransactionController;

require_once dirname(__DIR__) . '/bootstrap/bootstrap.php';

$router = new Router();
$router->get('/', [HomeController::class, 'index']);
$router->get('/ping', function () {
    echo 'pong';
});
$router->get('/transactions', [TransactionController::class, 'index']);
$router->get('/transactions/view', [TransactionController::class, 'listTransactions']);
$router->post('/transactions/upload', [TransactionController::class, 'upload']);

$request = ['uri' => $_SERVER['REQUEST_URI'], 'method' => $_SERVER['REQUEST_METHOD']];

$config = new Config($_ENV);

$app = new App($router, $request, $config);
$app->run();
