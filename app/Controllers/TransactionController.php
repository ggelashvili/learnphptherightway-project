<?php

declare(strict_types=1);

namespace App\Controllers;

use App\View;
#include the class
use App\Transaction;

class TransactionController
{
    public function upload()
    {
        if (isset($_FILES["csv"]))
        {
            if (file_exists($_FILES["csv"]["tmp_name"]))
            {
                $csv_file = fopen($_FILES["csv"]["tmp_name"], "r");
                $fields = fgetcsv($csv_file);
                require __DIR__ . "/../Model.php";
                // class not found here so i use require
                $transactionModel = new Transaction();
                while(($values = fgetcsv($csv_file)) !== false)
                {
                    $transactionModel->create($values);
                }
            }
        }
        return View::make("upload");
    }
    public function show()
    {
        return View::make("transactions");
    }
}