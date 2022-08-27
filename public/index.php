<?php

declare(strict_types = 1);

use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

$app       = require __DIR__ . '/../bootstrap.php';
$container = $app->getContainer();
$router    = require CONFIG_PATH . '/routes.php';

$router($app);

$app->add(TwigMiddleware::create($app, $container->get(Twig::class)));

$app->run();
