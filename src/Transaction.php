<?php

declare(strict_types=1);

class Transaction
{
    public function __construct(private float $amount, private string $description)
    {
    }

    public function addTax(float $rate): self
    {
        if ($rate > 0) $this->amount += $this->amount * $rate / 100;

        return $this;
    }

    public function applyDiscount(float $rate): self
    {
        if ($rate > 0) $this->amount -= $this->amount * $rate / 100;

        return $this;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function __destruct()
    {
        echo 'Destruct ' . $this->description . '<br/>';
    }
}
