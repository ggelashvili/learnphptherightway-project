<?php

declare(strict_types = 1);

namespace App\Contracts;

interface EmailValidationInterface
{
    public function verify(string $email): array;
}
