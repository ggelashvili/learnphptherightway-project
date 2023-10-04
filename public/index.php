<?php

declare(strict_types=1);

use App\CustomInvoice;
use App\Invoice;

require __DIR__ . '/../vendor/autoload.php';


$invoice1 = new Invoice(25, 'My Invoice');
//$invoice2 = new Invoice(100, 'My Invoice 2');
$invoice2 = new CustomInvoice(25, 'My Invoice');

$invoice3 = clone $invoice1;

//echo 'invoice1 == invoice2' . PHP_EOL;
//var_dump($invoice1 == $invoice2);
//echo '<br>';
//echo 'invoice1 === invoice2' . PHP_EOL;
//var_dump($invoice1 === $invoice2);
//
//echo '<br>';
//
//echo 'invoice1 == invoice3' . PHP_EOL;
//var_dump($invoice1 == $invoice3);
//echo '<br>';
//echo 'invoice1 === invoice3' . PHP_EOL;
//var_dump($invoice1 === $invoice3);
//echo '<br>';
//$invoice3->amount = 15561;
//var_dump($invoice1, $invoice3);


echo 'invoice1 == invoice2' . PHP_EOL;
var_dump($invoice1 == $invoice2);
echo '<br>';
echo 'invoice1 === invoice2' . PHP_EOL;
var_dump($invoice1 === $invoice2);
