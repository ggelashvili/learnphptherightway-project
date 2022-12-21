<?php

declare(strict_types=1);

namespace App\Models;

use App\Model;
use App\Services\CommonHelper;

class TransactionModel extends Model
{
    private static $tableName = 'transactions';

    public function create(array $data): ?int
    {
        $date = $data['date'];
        $check = $data['check'];
        $description = $data['description'];
        $amount = $data['amount'];

        if ($date && $description && $amount) {
            $stmt = $this->db->prepare(
                'INSERT INTO '.static::$tableName.' (date, check_no, description, amount) VALUES (?, ?, ?, ?)'
            );

            $stmt->execute([$date, $check, $description, $amount]);

            return (int) $this->db->lastInsertId();
        }

        return null;
    }

    public function findAll(): array
    {
        $stmt = $this->db->prepare(
            'SELECT * FROM '.static::$tableName.''
        );
        $stmt->execute();

        return $stmt->fetchAll() ?? [];
    }

    public function delete(int $id): void
    {
        $stmt = $this->db->prepare(
            'DELETE FROM '.static::$tableName.' WHERE id=?'
        );

        $stmt->execute([$id]);
    }

    public function calculateTotals(array $transactions): array
    {
        $totals = ['netTotal' => 0, 'totalIncome' => 0, 'totalExpense' => 0];
        foreach ($transactions as $transaction) {
            $totals['netTotal'] += $transaction['amount'];
            if ($transaction['amount'] >= 0) {
                $totals['totalIncome'] += $transaction['amount'];
            } else {
                $totals['totalExpense'] += $transaction['amount'];
            }
        }

        return $totals;
    }

    public function formatAmountByTotal(array $totals)
    {
        $commonHelper = new CommonHelper();
        foreach ($totals as $key => $total) {
            $totals[$key] = $commonHelper->currency($total);
        }

        return $totals;
    }

    public function bulkCreate(?array $transactions): void
    {
        $transactionModel = new TransactionModel();

        if ($transactions) {
            foreach ($transactions as $transaction) {
                $transactionModel->create($transaction);
            }
        }
    }
}
