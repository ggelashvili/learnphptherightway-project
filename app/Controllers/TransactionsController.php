<?php

namespace App\Controllers;

use App\Dto\TransactionDTO;
use App\Exceptions\InvalidTransactionFileException;
use App\Models\Transaction;
use App\Ui\View;
use DateTimeImmutable;
use Throwable;

class TransactionsController
{
    public function index(): View
    {
        return View::make('transactions', (new Transaction())->findAll());
    }


    /**
     * @throws InvalidTransactionFileException
     * @throws Throwable
     */
    public function uploadTransaction(): void
    {
        $transactionsFilename = $_FILES['transaction']['tmp_name'] ?? null;

        if ($transactionsFilename === null) {
            throw new InvalidTransactionFileException();
        }

        $transactions = $this->getTransactions(
            $transactionsFilename,
            [$this, 'extractTransaction']
        );

        $transactionModel = new Transaction();
        foreach ($transactions as $transaction) {
            $transactionModel->createFromDTO($transaction);
        }

        header('Location: /');
    }

    /**
     * @throws InvalidTransactionFileException
     */
    public function getTransactions(
        string $filename,
        ?callable $transactionHandler
    ): array {
        if ( ! file_exists($filename)) {
            throw new InvalidTransactionFileException();
        }

        $file = fopen($filename, 'r');

        fgetcsv($file);

        $transactions = [];

        while (($transaction = fgetcsv($file)) !== false) {
            if ($transactionHandler !== null) {
                $transaction = call_user_func(
                    $transactionHandler,
                    $transaction
                );
            }
            $transactions[] = $transaction;
        }

        return $transactions;
    }


    public function extractTransaction(array $transaction): TransactionDTO
    {
        [$date, $checkNumber, $description, $amount] = $transaction;

        $amount = (float)str_replace(['$', ','], '', $amount);

        if (empty($checkNumber)) {
            $checkNumber = null;
        } else {
            $checkNumber = (int)$checkNumber;
        }

        return new TransactionDTO(
            DateTimeImmutable::createFromFormat('m/d/Y', $date)->setTime(0, 0),
            $checkNumber,
            $description,
            $amount
        );
    }
}