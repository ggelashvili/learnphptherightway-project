<?php

declare(strict_types = 1);

//use App\App;
//use App\Config;
//use App\Container;
//use App\Controllers\GeneratorExampleController;
//use App\Controllers\HomeController;
//use App\Router;
use App\VarianceExample\AnimalFood;
use App\VarianceExample\CatShelter;
use App\VarianceExample\DogShelter;
use App\VarianceExample\Food;

require_once __DIR__ . '/../vendor/autoload.php';

//$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
//$dotenv->load();
//
//define('STORAGE_PATH', __DIR__ . '/../storage');
//define('VIEW_PATH', __DIR__ . '/../views');
//
//$container = new Container();
//$router    = new Router($container);
//
//$router
//    ->get('/', [HomeController::class, 'index'])
//    ->get('/examples/generator', [GeneratorExampleController::class, 'index']);
//
//(new App(
//    $container,
//    $router,
//    ['uri' => $_SERVER['REQUEST_URI'], 'method' => $_SERVER['REQUEST_METHOD']],
//    new Config($_ENV)
//))->run();


// Covariance
$kitty = (new CatShelter())->adopt('Ricky'); // Returns Cat (extends Animal)
$kitty->makeSound();
echo PHP_EOL;

$doggy = (new DogShelter())->adopt('Archie'); // Returns Dog (extends Animal)
$doggy->makeSound();
echo PHP_EOL;
$catFood = new AnimalFood();
// Contravariance
$kitty->eat($catFood);
echo PHP_EOL;

// Dog class can accept either
// Food class instances
// and Food child classes instances
$banana = new Food();
$doggy->eat($banana);
echo PHP_EOL;
$doggy->eat($catFood); // LSP is observed (widening type support)
echo PHP_EOL;

