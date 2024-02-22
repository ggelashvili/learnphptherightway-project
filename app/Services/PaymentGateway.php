<?php

declare(strict_types = 1);

namespace App\Services;

interface PaymentGateway
{
    public function charge(array $customer, float $amount, float $tax): bool;
}
