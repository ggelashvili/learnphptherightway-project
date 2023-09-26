<?php

declare(strict_types=1);

//spl_autoload_register(function ($class) {
//    $path = __DIR__ . '/../' . lcfirst(str_replace('\\', '/', $class)) . '.php';
//
//    if (file_exists($path)) {
//        require $path;
//    }
//});

require  __DIR__ . '/../vendor/autoload.php';

use App\PaymentGateway\Paddle\Transaction;

$paddleTransaction = new Transaction();

$id = new \Ramsey\Uuid\UuidFactory();

echo $id->uuid4();

var_dump($paddleTransaction);
