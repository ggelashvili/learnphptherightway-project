<?php

declare(strict_types = 1);

namespace App\Controllers;

use App\Attributes\Get;
use App\Services\InvoiceService;
use Twig\Environment as Twig;

class InvoiceController
{
    public function __construct(private Twig $twig, private InvoiceService $invoiceService)
    {
    }

    #[Get('/invoices')]
    public function index(): string
    {
        return $this->twig->render(
            'invoices/index.twig',
            ['invoices' => $this->invoiceService->getPaidInvoices()]
        );
    }
}
