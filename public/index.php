<?php

declare(strict_types=1);

use App\PaymentGateway\Paddle\Transaction;

require __DIR__ . '/../vendor/autoload.php';

$transaction = new Transaction(25);

// Trick how you can change property value in the object even-though property is set to private
//$reflectionProperty = new ReflectionProperty(Transaction::class, 'amount');
//$reflectionProperty->setAccessible(True);
//$reflectionProperty->setValue($transaction, 125);
//var_dump($reflectionProperty->getValue($transaction));
//$transaction->amount;

//$transaction->process();

$transaction->copyFrom(new Transaction(125));
