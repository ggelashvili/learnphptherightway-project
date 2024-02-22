<?php

declare(strict_types = 1);

namespace Tests\Unit\Services;

use App\Services\EmailService;
use App\Services\InvoiceService;
use App\Services\SalesTaxService;
use App\Services\StripePayment;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class InvoiceServiceTest extends TestCase
{
    #[Test] public function it_processes_invoice(): void
    {
        $salesTaxServiceMock = $this->createMock(SalesTaxService::class);
        $gatewayServiceMock = $this->createMock(StripePayment::class);
        $emailServiceMock    = $this->createMock(EmailService::class);

        $gatewayServiceMock->method('charge')->willReturn(true);

        // given invoice service
        $invoiceService = new InvoiceService(
            $salesTaxServiceMock,
            $gatewayServiceMock,
            $emailServiceMock
        );

        $customer = ['name' => 'Gio'];
        $amount   = 150;

        // when process is called
        $result = $invoiceService->process($customer, $amount);

        // then assert invoice is processed successfully
        $this->assertTrue($result);
    }

    #[Test] public function it_sends_receipt_email_when_invoice_is_processed(
    ): void
    {
        $customer = ['name' => 'Gio'];
        $salesTaxServiceMock = $this->createMock(SalesTaxService::class);
        $gatewayServiceMock = $this->createMock(StripePayment::class);
        $emailServiceMock    = $this->createMock(EmailService::class);

        $gatewayServiceMock->method('charge')->willReturn(true);

        $emailServiceMock
            ->expects($this->once())
            ->method('send')
            ->with($customer, 'receipt');

        // given invoice service
        $invoiceService = new InvoiceService(
            $salesTaxServiceMock,
            $gatewayServiceMock,
            $emailServiceMock
        );

        $amount   = 150;

        // when process is called
        $result = $invoiceService->process($customer, $amount);

        // then assert invoice is processed successfully
        $this->assertTrue($result);
    }
}
