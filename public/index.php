<?php
declare(strict_types=1);
require_once __DIR__ . '/../vendor/autoload.php';

use App\Application;

use App\Config;
use App\Router;


const STORAGE_PATH = __DIR__ . '/../storage';
const VIEWS_PATH = __DIR__ . '/../Views';


$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

$router = new Router();

$router->get('/', [App\Controllers\HomeController::class, "index"])
    ->post('/upload', [App\Controllers\HomeController::class, "upload"])
    ->get('/transaction', [App\Controllers\HomeController::class, "transaction"]);

(new Application($router, ['method' => $_SERVER['REQUEST_METHOD'],
    'uri' => $_SERVER['REQUEST_URI']],new Config($_ENV)))
        ->run();





