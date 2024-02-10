<?php

declare(strict_types=1);

use App\App;
use App\Config;
use App\Controllers\HomeController;
use App\Controllers\TransactionsController;
use App\Routing\HTTPMethod;
use App\Routing\HTTPRequest;
use App\Routing\Router;

define("SOURCE_DIRECTORY", dirname(__DIR__));
const VENDOR_DIRNAME    = 'vendor';
const AUTOLOAD_FILENAME = 'autoload.php';
const AUTOLOAD_PATH
                        = SOURCE_DIRECTORY.DIRECTORY_SEPARATOR.VENDOR_DIRNAME
                          .DIRECTORY_SEPARATOR.AUTOLOAD_FILENAME;
const STORAGE_PATH      = SOURCE_DIRECTORY.DIRECTORY_SEPARATOR.'storage';
const VIEWS_PATH        = SOURCE_DIRECTORY.DIRECTORY_SEPARATOR.'views';


require_once AUTOLOAD_PATH;

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();


$router = new Router();

$router
    ->get('/', [HomeController::class, 'index'])
    ->get('/transactions', [TransactionsController::class, 'index']);

(new App(
    $router,
    new HTTPRequest(
        $_SERVER['REQUEST_URI'],
        HTTPMethod::from($_SERVER['REQUEST_METHOD'])
    ),
    new Config($_ENV)
))->run();
