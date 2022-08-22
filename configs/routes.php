<?php

declare(strict_types = 1);

use App\Controllers\HomeController;
use App\Controllers\InvoiceController;
use Slim\App;

return function(App $app) {
    $app->get('/', [HomeController::class, 'index']);
    $app->get('/invoices', [InvoiceController::class, 'index']);
};
