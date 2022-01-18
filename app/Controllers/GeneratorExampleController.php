<?php

declare(strict_types = 1);

namespace App\Controllers;

use App\Attributes\Route;
use App\Models\Ticket;
use Generator;

class GeneratorExampleController
{
    public function __construct(private Ticket $ticketModel)
    {
    }

    #[Route('/examples/generator')]
    public function index()
    {
        $tickets = $this->ticketModel->all();

        foreach($tickets as $ticket) {
            echo $ticket['id'] . ': ' . substr($ticket['content'], 0, 15) . '<br />';
        }
    }

    private function lazyRange(int $start, int $end): Generator
    {
        for ($i = $start; $i <= $end; $i++) {
            yield $i;
        }
    }
}
