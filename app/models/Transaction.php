<?php 

namespace App\Models;
use DateTime;
use App\App;
class Transaction extends Model{

    public function create(array $transaction){
        $stmt = 'INSERT INTO transactions(created_date, `description`, amount, check_number)
        VALUES(?,?,?,?)';

        $preparedStmt = static::$db->prepare($stmt);
        
        $preparedStmt->execute([
            $this->strToDateTime($transaction[0])->format('Y-m-d'),
            $transaction[2],
            $this->strToFloat($transaction[3]),
            $this->strToInt($transaction[1])
        ]);
    }

    public static function retrieveAll($dateFormat = 'M j, Y'){
        
        if(!isset(static::$db)){
            static::$db = App::db();
        }
        $transactions = static::$db->query('
        SELECT created_date, description, amount, check_number
        FROM transactions')->fetchAll();
        
        $netTotal = 0;
        $totalIncome = 0;
        $totalExpenses = 0;
        //Remember to pass values by reference if youn want to change them in a foreach loop.
        foreach($transactions as &$transaction){
            
            $transaction['created_date'] = DateTime::createFromFormat(
                'Y-m-d H:i:s', $transaction['created_date']
            )->format($dateFormat);

            $isNegativeAmount = $transaction['amount'] < 0;
            
            if($isNegativeAmount){
                $totalExpenses += abs($transaction['amount']);
            }
            else{
                $totalIncome += abs($transaction['amount']);
            }

            $netTotal += abs($transaction['amount']); 

            $transaction['amount'] = static::formatDollarAmount($transaction['amount']);
            
            $transaction['color'] = 'green';
            
            if($isNegativeAmount){
                $transaction['color'] = 'red';
            }
        }

        return ['transactions' => $transactions, 
        'netTotal' => static::formatDollarAmount($netTotal), 
        'totalIncome' => static::formatDollarAmount($totalIncome),
        'totalExpenses' => static::formatDollarAmount($netTotal, $totalExpenses)
        ];
    }

    public static function processCsv($csv){
        $transactionsArray = [];

        while(($transaction = fgetcsv($csv)) !== false){
            $transactionsArray[] = $transaction;
        }

        return $transactionsArray;
    }

    public static function formatDollarAmount($amount){
        return ($amount < 0 ? '-': '') 
            . '$' 
            . number_format(abs($amount), 2);
    }
}