<?php

declare(strict_types = 1);

namespace App\Models;

use App\App;
use App\Model;

class Transactions extends Model
{
    protected static $transactions = [];

    public static function getTransactions(): array
    {
        $db = App::db();
        static::$transactions = [];
        $result = $db->query('SELECT * FROM transactions ORDER BY date');
        foreach ($result as $row) {
          static::$transactions[] = $row;
        }
        return static::$transactions;
    }
    public static function uploadTransactions(array $files): void
    {
        $db = App::db();

        foreach ($files as $file) {
            $sql = 'INSERT INTO transactions (date, checking, description, amount)
                    VALUES (:date, :checking, :description, :amount)';
            $sth = $db->prepare($sql);
            if (($file = fopen($file, 'r')) !== false) {
                while (($row = fgetcsv($file)) !== false) {     //enclosure: '"'
                    if ($row[0] !== 'Date') {
                        $sth->execute([
                          'date'=> date('y-m-d', strtotime($row[0])),
                          'checking'=> $row[1],
                          'description'=> $row[2],
                          'amount' => (float) str_replace(['$', ','], ['', ''], $row[3])
                        ]);
                    }
                }
            }
        }
    }
    public static function calculateTotals(): array
    {
        $incomeTotal = 0;
        $expenseTotal = 0;
        $netTotal = 0;
        foreach (static::$transactions as $transaction) {
          if ($transaction['amount'] > 0) {
            $incomeTotal += $transaction['amount'];
          }
          else {
            $expenseTotal += $transaction['amount'];
          }
          $netTotal += $transaction['amount'];
        }
        return [
          'income' => $incomeTotal,
          'expense' => $expenseTotal,
          'net' => $netTotal,
        ];
    }
    
}