<?php

namespace App\Models;

use App\Dto\TransactionDTO;
use DateTimeImmutable;
use DateTimeInterface;
use PDO;
use PDOStatement;
use Throwable;

class Transaction extends Model
{
    /**
     * @throws Throwable
     */
    public function createFromDTO(TransactionDTO $transactionDTO): int
    {
        return $this->create(
            date: $transactionDTO->date,
            description: $transactionDTO->description,
            amount: $transactionDTO->amount,
            checkNumber: $transactionDTO->checkNumber
        );
    }

    /**
     * @throws Throwable
     */
    public function create(
        DateTimeInterface $date,
        string $description,
        float $amount,
        ?int $checkNumber = null
    ): int {
        try {
            $this->db->beginTransaction();

            $insertNewTransactionStatement = $this->getInsertStatement();
            $insertNewTransactionStatement->execute(
                $this->extract($date, $description, $amount, $checkNumber)
            );
            $transactionId = $this->db->lastInsertId();

            $this->db->commit();
        } catch (Throwable $throwable) {
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }

            throw $throwable;
        } finally {
            return $transactionId;
        }
    }

    private function getInsertStatement(): PDOStatement
    {
        return $this->db->prepare(
            'INSERT INTO transactions (date, check_number, description, amount)
                   VALUES (:date, :check_number, :description, :amount)'
        );
    }

    private function extract(
        DateTimeInterface $date,
        string $description,
        float $amount,
        ?int $checkNumber = null
    ): array {
        return [
            ':date'         => $date->format('Y-m-d'),
            ':check_number' => $checkNumber,
            ':description'  => $description,
            ':amount'       => $amount,
        ];
    }

    /** @param  TransactionDTO[]  $transactionDTOs
     * @throws Throwable
     */
    public function createFromDTOs(array $transactionDTOs): void
    {
        $this->db->beginTransaction();
        try {
            $insertNewPreparedStatement = $this->getInsertStatement();

            foreach ($transactionDTOs as $transactionDTO) {
                $insertNewPreparedStatement->execute(
                    $this->extract(
                        $transactionDTO->date,
                        $transactionDTO->description,
                        $transactionDTO->amount,
                        $transactionDTO->checkNumber
                    )
                );
            }
        } catch (Throwable $throwable) {
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }

            throw $throwable;
        }

        $this->db->commit();
    }

    public function findAll(): false|array
    {
        $selectPrepare = $this->db->prepare('SELECT * FROM transactions');
        $selectPrepare->execute();

        $transactions = $selectPrepare->fetchAll(PDO::FETCH_ASSOC);

        return array_map(fn(array $transaction) => new TransactionDTO(
            DateTimeImmutable::createFromFormat('Y-m-d', $transaction['date']),
            $transaction['check_number'],
            $transaction['description'],
            $transaction['amount']
        ), $transactions);
    }

    public function calculateTotalIncome(): float
    {
        return $this->calculateTotalAmount(true);
    }

    private function calculateTotalAmount(bool $isPositive): float
    {
        if ($isPositive) {
            $sqlStatement
                = 'SELECT SUM(ABS(amount)) FROM transactions WHERE amount > 0';
        } else {
            $sqlStatement
                = 'SELECT SUM(ABS(amount)) FROM transactions WHERE amount < 0';
        }


        $query  = $this->db->query($sqlStatement);
        $result = $query->fetchColumn();

        return $result !== false ? $result : 0;
    }

    public function calculateTotalExpense(): float
    {
        return $this->calculateTotalAmount(false);
    }

    public function calculateNetTotal(
        float $totalIncome,
        float $totalExpense
    ): float|int {
        return abs($totalIncome - $totalExpense);
    }

}