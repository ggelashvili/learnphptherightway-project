<?php
declare(strict_types=1);

namespace App\Models;
use App\Model;

class Transaction extends Model{
    public function create($csvFile) {
       if(! file_exists($csvFile)) {
          throw new \Exception('file not found');
       }
       
       try {
            $this->db->beginTransaction();

            $transactions = $this->processCsv($csvFile);
            $transformedArr = array_map(function($arr) {
            return [
                'trans_date' => date('Y-m-d', strtotime($arr[0])),
                'amount' => (float) str_replace(['$', ','], '', $arr[3]),
                'description' => $arr[2],
                'check_no' => $arr[1]
            ];
            }, $transactions);
    
            $query = "INSERT INTO transactions (description,trans_date,check_no,amount) VALUES (:desc,:trans_date,:check_no,:amount)";
            $stmt = $this->db->prepare($query);
    
            foreach($transformedArr as $trans) {
                $stmt->execute([
                    ':desc' => $trans['description'],
                    ':trans_date' => $trans['trans_date'],
                    ':check_no' => $trans['check_no'],
                    ':amount' => $trans['amount'],
                ]);
            }

            $this->db->commit();
       } catch(\PDOException $e) {
           if($this->db->inTransaction()) {
               $this->db->rollback();
           }
           throw new \PDOException($e->getMessage());
       }
    }

    public function getAll()
    {
        $query = "SELECT * from transactions";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    protected function processCsv($csvFile) {

        if(! file_exists($csvFile)) {
            throw new \Exception('file not found');
        }

        $file = fopen($csvFile, 'r');
    
        fgetcsv($file);
    
        $transactions = [];
    
        while (($transaction = fgetcsv($file)) !== false) {
            $transactions[] = $transaction;
        }

        return $transactions;
    }

    public function calculateTotals(array $transactions) {
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
}