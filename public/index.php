<?php

declare(strict_types=1);

use App\Toaster;
use App\ToasterPro;

require __DIR__ . '/../vendor/autoload.php';

$toaster = new Toaster();
//$toaster = new Toaster();
$toaster->addSlice(slice: 'bread');
$toaster->addSlice('bread');
$toaster->addSlice('bread');
//$toaster->toastBagel();

foo($toaster);
function foo(Toaster $toaster) {
//    $toaster->toast();
    $toaster->toastBagel();
}
//$toasterPro = new ToasterPro();
