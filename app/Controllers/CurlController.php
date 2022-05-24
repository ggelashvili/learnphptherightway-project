<?php

declare(strict_types = 1);

namespace App\Controllers;

use App\Attributes\Get;
use App\Contracts\EmailValidationInterface;

class CurlController
{
    public function __construct(private EmailValidationInterface $emailValidationService)
    {
    }

    #[Get('/curl')]
    public function index()
    {
        $email  = 'programwithgio@gmail.com';
        $result = $this->emailValidationService->verify($email);

        echo '<pre>';
        print_r($result);
        echo '</pre>';
    }
}
