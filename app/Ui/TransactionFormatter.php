<?php

namespace App\Ui;

use App\Dto\TransactionDTO;

class TransactionFormatter
{
    /** @param  TransactionDTO[]  $transactions */
    public function format(array $transactions): array
    {
        return array_map(function (TransactionDTO $transaction) {
            return [
                'date'          => $transaction->date->format('M j, Y'),
                'checkedNumber' => $transaction->checkNumber,
                'description'   => $transaction->description,
                'amount'        => (new UsdCurrencyFormatter())->format(
                    $transaction->amount
                ),
            ];
        }, $transactions);
    }
}