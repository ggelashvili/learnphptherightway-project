<?php

declare(strict_types = 1);

namespace App\Controllers;

use App\Attributes\Get;
use App\Attributes\Route;
use App\Enums\HttpMethod;
use Twig\Environment AS Twig;

class HomeController
{
    public function __construct(private Twig $twig)
    {
    }

    #[Get('/')]
    #[Route('/home', HttpMethod::Head)]
    public function index()
    {
        return $this->twig->render('index.twig');
    }
}
