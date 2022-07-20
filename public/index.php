<?php

declare(strict_types = 1);

use App\App;
use App\Config;
use App\Controllers\TransactionController;
use App\Router;

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

const STORAGE_PATH = __DIR__ . '/../storage';
const VIEW_PATH = __DIR__ . '/../views';

$router = new Router();

$router
    ->get('/MVC-file-parse/transactions', [TransactionController::class, 'index'])
    ->get('/MVC-file-parse/transactions/upload', [TransactionController::class, 'transactionUploadPage'])
    ->post('/MVC-file-parse/transactions/store', [TransactionController::class, 'storeFromFilesToDB']);

(new App(
    $router,
    new Config($_ENV)
))->run(['uri' => $_SERVER['REQUEST_URI'], 'method' => $_SERVER['REQUEST_METHOD']]);

//          REQUEST LIFECYCLE
// index(run()) -> app -> router -> TransactionController -> view (returns new view object)
