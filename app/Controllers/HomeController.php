<?php

declare(strict_types = 1);

namespace App\Controllers;

use App\Models\Invoice;
use App\Models\SignUp;
use App\Models\User;
use App\View;

class HomeController
{
    public function index(): View
    {
        return View::make('index');
    }
}
