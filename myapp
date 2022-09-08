<?php

declare(strict_types = 1);

use Doctrine\Migrations\Configuration\EntityManager\ExistingEntityManager;
use Doctrine\Migrations\Configuration\Migration\PhpFile;
use Doctrine\Migrations\DependencyFactory;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Doctrine\ORM\Tools\Console\EntityManagerProvider\SingleManagerProvider;
use Symfony\Component\Console\Application;

$app       = require 'bootstrap.php';
$container = $app->getContainer();

$entityManager = $container->get(EntityManager::class);

$config            = new PhpFile(CONFIG_PATH . '/migrations.php');
$dependencyFactory = DependencyFactory::fromEntityManager($config, new ExistingEntityManager($entityManager));

$migrationCommands = require CONFIG_PATH . '/migration_commands.php';
$customCommands    = require CONFIG_PATH . '/commands.php';

$application = new Application('App Name', '1.0');

ConsoleRunner::addCommands($application, new SingleManagerProvider($entityManager));

$application->addCommands($migrationCommands($dependencyFactory));
$application->addCommands(array_map(fn($command) => $container->get($command), $customCommands));

$application->run();
