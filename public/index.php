<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

//$invoice = new \App\Invoice(15);
//
//$invoice->amount = 35;
//
//var_dump(isset($invoice->amount));
//var_dump($invoice);
//unset($invoice->amount);
//
//var_dump($invoice);

//$invoice = new \App\Invoice();
//\App\Invoice::process(1, 2, 3);
//$invoice->process(1, 2, 3);
//$invoice->process(15, 'Some description');

//$invoice = new \App\Invoice();
//var_dump($invoice instanceof Stringable);


//$invoice = new \App\Invoice();
//var_dump(is_callable($invoice));
//$invoice();

$invoice = new \App\Invoice();
var_dump($invoice);
