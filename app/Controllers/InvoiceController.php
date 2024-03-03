<?php

declare(strict_types = 1);

namespace App\Controllers;

use App\Attributes\Controller;
use App\Attributes\Get;
use App\Enums\InvoiceStatus;
use App\Models\Invoice;
use App\View;

#[Controller]
class InvoiceController
{
    #[Get('/invoices')]
    public function index(): View
    {
        $invoices = (new Invoice())->all(InvoiceStatus::Void);

        return View::make('invoices/index', ['invoices' => $invoices]);
    }
}
