<?php

namespace App\Models;

use App\Dto\TransactionDTO;
use DateTimeInterface;
use PDO;
use Throwable;

class Transaction extends Model
{
    /**
     * @throws Throwable
     */
    public function createFromDTO(TransactionDTO $transactionDTO): int
    {
        return $this->create(
            $transactionDTO->date,
            $transactionDTO->checkNumber,
            $transactionDTO->description,
            $transactionDTO->amount
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

            $insertNewTransactionStatement = $this->db->prepare(
                'INSERT INTO transactions (date, check_number, description, amount)
                   VALUES (:date, :check_number, :description, :amount)'
            );

            $insertNewTransactionStatement->execute([
                ':date'         => $date,
                ':check_number' => $checkNumber,
                ':description'  => $description,
                ':amount'       => $amount,
            ]);

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

    public function findAll(): false|array
    {
        $selectPrepare = $this->db->prepare('SELECT * FROM transactions');
        $selectPrepare->execute();

        return $selectPrepare->fetchAll(
            PDO::FETCH_CLASS,
            TransactionDTO::class
        );
    }


}