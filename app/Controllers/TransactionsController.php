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
        $transactionModel = new Transaction();

        $transactions = $transactionModel->findAll();
        $totalIncome  = $transactionModel->calculateTotalIncome();
        $totalExpense = $transactionModel->calculateTotalExpense();
        $netTotal     = $transactionModel->calculateNetTotal(
            $totalIncome,
            $totalExpense
        );

        return View::make(
            'transactions',
            [
                'transactions' => $transactions,
                'totalIncome'  => $totalIncome,
                'totalExpense' => $totalExpense,
                'netTotal'     => $netTotal,
            ]
        );
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
        $transactionModel->createFromDTOs($transactions);

        header('Location: /transactions');
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
            DateTimeImmutable::createFromFormat('d/m/Y', $date),
            $checkNumber,
            $description,
            $amount
        );
    }
}