<?php
declare(strict_types=1);
namespace App\Controllers;
use App\View;
use \App\App;
use App\Models\CsvProcessor;
use App\Models\Transaction;


class CsvUploadController{

    
    
    public function index(): string{
    
        return View::make('transactions', Transaction::retrieveAll())->render();
    }

    public function upload(){
        $db = App::db();
        
        
        $newPath = STORAGE_PATH . '/' . $_FILES['csv_file']['name'];
        move_uploaded_file(
            $_FILES['csv_file']['tmp_name'], 
            $newPath
        );

        try{
            $db->beginTransaction();

            $newTransactions = Transaction::processCsv(fopen($newPath, 'r'));
            array_shift($newTransactions);
            foreach($newTransactions as $transactionarray){
                (new Transaction())->create($transactionarray);
            }
            $db->commit();
        }
        catch(\Throwable $e){
            if($db->inTransaction()){
                $db->rollback();
            }
            
            throw $e;
        }

       return View::make('transactions', Transaction::retrieveAll())->render();
    }

    
}