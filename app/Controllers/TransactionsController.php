<?php

declare(strict_types = 1);

namespace App\Controllers;

use App\Config;
use App\Models\TransactionModel;
use App\View;
use APP\DB;
use PDO;
use Exception;

class TransactionsController
{
    public function index() : View
    {
      $transactionModel = new TransactionModel();
      $data = $transactionModel->getAllTransactions();

      return View::make('transactions', ["data" => $data, "layout" => "defaultLayout"]);
    }

    public function showUploadTransactionsForm(): View
    { 
      return View::make('uploadTransaction', ["layout" => "defaultLayout"]);
    }

    public function uploadTransactions(): ?View
    {
      $transactionModel = new TransactionModel();

      try {
          $transactions = $transactionModel->readMultipleFilesContents($_FILES["transactions"]);
          $transactionModel->uploadTransactionsToDB($transactions);
      } catch (Exception $e) {
          return View::make('uploadTransaction', ["layout" => "defaultLayout", "error" => $e->getMessage()]);
      }

      header("Location: /transactions", true, 301);
      die();
    }
}
