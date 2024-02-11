<?php

namespace App\Dto;

use DateTimeInterface;

readonly class TransactionDTO
{
    public function __construct(
        public DateTimeInterface $date,
        public ?int $checkNumber,
        public string $description,
        public float $amount
    ) {
    }
}