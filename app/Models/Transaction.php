<?php

declare(strict_types=1);

namespace App\Models;

use App\Model;
use DateTime;

class Transaction extends Model
{
    protected int $id;
    public DateTime $date;
    public string $check;
    public string $description;
    public float $amount;


    public function all(): TransactionCollection
    {
        $query = 'select id, date, check_number, description, amount from transactions';

        $statement = $this->db->query($query);

        $transactions = [];

        while (($row = $statement->fetch()) !== false) {
            $transactions[] = $this->createFromRow($row);
        }

        return new TransactionCollection($transactions);
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
    public function createFromRow(array $row): static
    {
        $id = (int) $row['id'];
        $date = DateTime::createFromFormat('Y-m-d', $row['date']);
        $check = (string) $row['check_number'];
        $description = (string) $row['description'];
        $amount = (float) $row['amount'];

        $transaction = Transaction::create($date, $check, $description, $amount);
        $transaction->id = $id;

        return $transaction;
    }
}
