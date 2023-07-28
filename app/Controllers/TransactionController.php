<?php

declare(strict_types=1);

namespace App\Controllers;

use App\View;
use App\Transaction;

class TransactionController
{
    public function upload()
    {
        return View::make("upload");
    }

    public function show()
    {
        $total_income = 0;
        $total_expense = 0;
        $data = (new transaction)->getData();
        foreach($data as &$row)
        {
            $row["date"] = date('M j, y', strtotime($row['date']));
            $amount = (float) str_replace(["$", ","], "", $row["amount"]);
            if ($amount > 0)
            {
                $total_income += $amount;
            }
            else
            {
                $total_expense += $amount;
            }
            $row["amount"] = $amount;
        }
        return View::make("transactions", ["data" => $data, "total_income" => "$" . (string) $total_income
                            ,"total_expense" => str_replace("-", "-$", (string) $total_expense)
                            ,"net_total" => "$" . (string) ($total_income + $total_expense)]);
    }

    public function loadCsv()
    {
        if (isset($_FILES["csv"]))
        {
            if (file_exists($_FILES["csv"]["tmp_name"]))
            {
                $csv_file = fopen($_FILES["csv"]["tmp_name"], "r");
                $fields = fgetcsv($csv_file);
                $transactionModel = new Transaction();
                while(($values = fgetcsv($csv_file)) !== false)
                {
                    $transactionModel->create($values);
                }
            }
        }

        return $this->upload();
    }
}