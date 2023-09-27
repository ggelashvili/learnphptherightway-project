<?php

declare(strict_types=1);

use App\PaymentGateway\DB;
use App\PaymentGateway\Paddle\Transaction;

require  __DIR__ . '/../vendor/autoload.php';

$transaction = new Transaction(25, 'Transaction 1');

var_dump($transaction::getCount(), Transaction::getCount());

$db = DB::getInstance([]);
var_dump($transaction::getCount(), $transaction->getCount());
var_dump($transaction->process());
