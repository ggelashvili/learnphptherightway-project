<?php

declare(strict_types=1);

namespace App\Models;

use App\Model;
use DateTime;

class Transaction extends Model
{
    protected int $id;
    protected DateTime $date;
    protected string $check;
    protected string $description;
    protected float $amount;

    public function all(): array
    {
        $query = 'select id, date, check_number, description, amount from transactions';

        $statement = $this->db->query($query);

        $transactions = [];

        while (($row = $statement->fetch()) !== false) {
            $transaction = Transaction::create(
                DateTime::createFromFormat('Y-m-d', $row['date']),
                $row['check_number'] ?? '',
                $row['description'] ?? '',
                (float)$row['amount']
            );

            $transaction->setId($row['id']);

            $transactions[] = $transaction;
        }

        return $transactions;
    }

    public static function create(DateTime $date, string $check, string $description, float $amount): static
    {
        $transaction = new static();

        $transaction->date = $date;
        $transaction->check = $check;
        $transaction->description = $description;
        $transaction->amount = $amount;

        return $transaction;
    }

    protected function setId(int $id)
    {
        $this->id = $id;
    }
}
