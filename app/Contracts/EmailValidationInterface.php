<?php

declare(strict_types = 1);

namespace App\Contracts;

use App\DTO\EmailValidationResult;

interface EmailValidationInterface
{
    public function verify(string $email): EmailValidationResult;
}
