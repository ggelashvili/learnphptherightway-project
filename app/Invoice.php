<?php

namespace App;
class Invoice
{
    /**
     * @param float $amount
     * @param string $description
     */
    public function __construct(public float $amount, public string $description)
    {
    }
}
