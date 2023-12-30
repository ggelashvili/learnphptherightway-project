<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Helpers\File;
use App\Models\TransactionModel;
use App\View;

class HomeController
{
    public function index(): View
    {

        return View::make('index');
    }

    public function upload()
    {
        $content = [];
        $newFilePath = STORAGE_PATH . '/' . $_FILES['trans_csv']['name'];
        move_uploaded_file($_FILES['trans_csv']['tmp_name'], $newFilePath);
        [$headers, $content] = (new File($newFilePath))->csv();
        $trans_ids = (new TransactionModel())->create($headers, $content);
        echo "<pre>";
        var_dump($trans_ids);
        echo "</pre>";
    }
    public function transactions(): View
    {
        $transactions = (new TransactionModel)->all();
        // echo "<pre>";
        // var_dump($transactions);
        // echo "</pre>";
        return View::make('transactions', ["transactions" => $transactions]);
    }
}
