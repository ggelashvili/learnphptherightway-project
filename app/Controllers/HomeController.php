<?php

declare(strict_types = 1);

namespace App\Controllers;

use App\Ui\View;

class HomeController
{
    public function index(): View
    {
        return View::make('index');
    }


}
