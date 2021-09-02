<?php

declare(strict_types = 1);

namespace App\Services;

class InvoiceService
{
    public function process(array $customer, float $amount): bool
    {
        $salesTaxService = new SalesTaxService();
        $gatewayService  = new PaymentGatewayService();
        $emailService    = new EmailService();

        // 1. calculate sales tax
        $tax = $salesTaxService->calculate($amount, $customer);

        // 2. process invoice
        if (! $gatewayService->charge($customer, $amount, $tax)) {
            return false;
        }

        // 3. send receipt
        $emailService->send($customer, 'receipt');

        return true;
    }
}
