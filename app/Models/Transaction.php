<?php

namespace App\Models;

use App\Model;
use NumberFormatter;

class Transaction extends Model
{
    private int $id;
    private \DateTime $date;
    private int $check;
    private string $description;
    private float $amount;

    /**
     * @param \DateTime $date
     * @param int $check
     * @param string $description
     * @param float $amount
     * @param int|null $id
     */
    public function __construct(\DateTime $date, int $check, string $description, float $amount, ?int $id = 0)
    {
        parent::__construct();
        $this->date = $date;
        $this->check = $check;
        $this->description = $description;
        $this->amount = $amount;
        $this->id = $id;
    }

    /**
     * @return self[]
     */
    public static function fetchAll(): array
    {
        $query = self::getDb()->query(
            "SELECT `date`, `check`, `description`, `amount`, `id` FROM transactions"
        );

        $results = [];

        foreach ($query as $row) {
            $transaction = new Transaction(
                \DateTime::createFromFormat('Y-m-d', $row['date']),
                $row['check'],
                $row['description'],
                $row['amount'],
                $row['id']
            );

            $results[] = $transaction;
        }

        return $results;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return \DateTime
     */
    public function getDate(): \DateTime
    {
        return $this->date;
    }

    /**
     * @return int
     */
    public function getCheck(): int
    {
        return $this->check;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * @param float $amount
     * @return string
     */
    public static function currencyFormatter(float $amount): string
    {
        $fmt = new NumberFormatter('en_US', NumberFormatter::CURRENCY);
        return $fmt->formatCurrency($amount, 'USD');
    }

    public function create(): self
    {
        $query = $this->db->prepare(
            "INSERT INTO transactions (`date`, `check`, `description`, `amount`) VALUES (?, ?, ?, ?)"
        );

        $query->execute([
            $this->date->format('Y-m-d'),
            $this->check,
            $this->description,
            $this->amount
        ]);

        return $this;
    }

}