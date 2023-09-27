<?php

declare(strict_types=1);

use App\Enums\Status;
use App\PaymentGateway\Paddle\Transaction;

require  __DIR__ . '/../vendor/autoload.php';

$transaction = new Transaction();

//var_dump(Transaction::STATUS_PAID, $transaction::STATUS_PENDING);
$transaction->setStatus(Status::PAID);
var_dump($transaction);
