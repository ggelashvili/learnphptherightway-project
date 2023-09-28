<?php

declare(strict_types=1);

namespace app\PaymentGateway\Paddle;

class Transaction
{
    private float $amount;

    public function __construct(float $amount)
    {
        $this->amount = $amount;
    }

    public function copyFrom(Transaction $transaction)
    {
        var_dump($transaction->amount, $transaction->sendEmail());
    }

    public function process()
    {
        echo "Processing $ {$this->amount} transaction";

        $this->generateReceipt();
        $this->sendEmail();
    }

    private function generateReceipt()
    {

    }

    private function sendEmail()
    {
        return true;
    }
}
