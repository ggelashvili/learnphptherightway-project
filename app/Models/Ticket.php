<?php

declare(strict_types = 1);

namespace App\Models;

use App\Model;

class Ticket extends Model
{
    public function all(): array
    {
        $stmt = $this->db->query(
            'SELECT *
             FROM tickets'
        );

        return $stmt->fetchAll();
    }
}
