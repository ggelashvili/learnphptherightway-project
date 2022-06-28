<?php

declare(strict_types = 1);

namespace App\Controllers;

use App\Attributes\Get;
use App\Enums\InvoiceStatus;
use App\Models\Invoice;
use Twig\Environment AS Twig;

class InvoiceController
{
    public function __construct(private Twig $twig)
    {
    }

    #[Get('/invoices')]
    public function index(): string
    {
        $invoices = Invoice::query()
           ->where('status', InvoiceStatus::Paid)
           ->get()
           ->map(
               fn(Invoice $invoice) => [
                   'invoiceNumber' => $invoice->invoice_number,
                   'amount'        => $invoice->amount,
                   'status'        => $invoice->status->toString(),
                   'dueDate'       => $invoice->due_date->toDateTimeString(),
               ]
           )
           ->toArray();

        return $this->twig->render('invoices/index.twig', ['invoices' => $invoices]);
    }
}
