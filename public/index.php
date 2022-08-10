<?php

declare(strict_types = 1);

use App\Config;
use App\Controllers\HomeController;
use App\Controllers\InvoiceController;
use DI\Container;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Dotenv\Dotenv;
use Slim\Factory\AppFactory;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;
use Twig\Extra\Intl\IntlExtension;

use function DI\create;

require_once __DIR__ . '/../vendor/autoload.php';

define('STORAGE_PATH', __DIR__ . '/../storage');
define('VIEW_PATH', __DIR__ . '/../views');

$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

// Create Container using PHP-DI
$container = new Container();

$container->set(Config::class, create(Config::class)->constructor($_ENV));
$container->set(EntityManager::class, fn(Config $config) => EntityManager::create(
    $config->db,
    ORMSetup::createAttributeMetadataConfiguration([__DIR__ . '/../app/Entity'])
));

// Set container to create App with on AppFactory
AppFactory::setContainer($container);

$app = AppFactory::create();

$app->get('/', [HomeController::class, 'index']);
$app->get('/invoices', [InvoiceController::class, 'index']);

$twig = Twig::create(VIEW_PATH, [
    'cache'       => STORAGE_PATH . '/cache',
    'auto_reload' => true,
]);

$twig->addExtension(new IntlExtension());

$app->add(TwigMiddleware::create($app, $twig));

$app->run();
