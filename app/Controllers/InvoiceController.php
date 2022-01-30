<?php

declare(strict_types = 1);

namespace App\Controllers;

use App\Attributes\Get;
use App\Enums\InvoiceStatus;
use App\Models\Invoice;
use App\View;

class InvoiceController
{
    #[Get('/invoices')]
    public function index(): View
    {
        $invoices = (new Invoice())->all(InvoiceStatus::Paid);

        return View::make('invoices/index', ['invoices' => $invoices]);
    }
}
