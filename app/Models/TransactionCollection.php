<?php

declare(strict_types=1);

namespace App\Models;

class TransactionCollection implements \IteratorAggregate
{
    /**
     * @param Transaction[] $transactions
     */
    public function __construct(private array $transactions = [])
    {
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->transactions);
    }
}
