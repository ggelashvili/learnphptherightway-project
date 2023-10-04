<?php

namespace App;

class CustomInvoice extends Invoice
{

    /**
     * @param int $amount
     * @param string $description
     */
    public function __construct(int $amount, string $description)
    {
        parent::__construct($amount, $description);
    }
}
