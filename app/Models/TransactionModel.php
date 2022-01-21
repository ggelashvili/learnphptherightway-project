<?php

declare(strict_types = 1);

namespace App\Models;

use App\Config;
use App\DB;
use App\Exceptions\EmptyFileException;
use App\Exceptions\InvalidFileContentsException;
use App\Exceptions\UnsupportedFileExtensionException;
use App\Exceptions\UploadException;
use App\Model;
use PDO;
use DateTime;
use Exception;

class TransactionModel extends Model  
{
    public function getAllTransactions() : array {
      $data = [];

      $stmt = $this->db->query("SELECT date, check_number, description, amount FROM transactions;", PDO::FETCH_ASSOC);

      $transactions = $stmt->fetchAll();

      foreach ($transactions as &$transaction) {
        $transaction = $this->formatTransactionForView($transaction);
      }

      $data["totalIncome"] = $this->calculateTotalIncome($transactions);
      $data["totalExpense"] = $this->calculateTotalExpense($transactions);
      $data["netTotal"] = $this->calculateNetTotal($transactions);
      $data["transactions"] = $transactions;

      return $data;
    }

    protected function readFileContents(string $filePath, bool $hasHeader = true) : array | bool {

      $fileContents = [];

      $file = fopen($filePath, 'r');

      if(!($line = fgetcsv($file))) 
      {
        throw new EmptyFileException(message: "Uploaded file is empty.");
      }
      
      //Checking if the file has a header.
      if(!$hasHeader) 
      {
        rewind($file);
      }

      while (($line = fgetcsv($file)) !== FALSE) 
      {
        if ( 
          (isset($line[0]) && !empty($line[0])) &&
          (isset($line[1])) &&
          (isset($line[2]) && !empty($line[2])) &&
          (isset($line[3]) && !empty($line[3]))
        ) 
        {
          $line["date"] = $line[0];
          unset($line[0]);

          $line["check_number"] = $line[1];
          unset($line[1]);

          $line["description"] = $line[2];
          unset($line[2]);

          $line["amount"] = $line[3];
          unset($line[3]);

        } else {
          throw new InvalidFileContentsException("Please check file contents.");
        }

        $fileContents[] = $line; 
      }

      fclose($file);

      return $fileContents;
    }
    
    public function readMultipleFilesContents(array $files) : array
    {
      $multipleFilesContents = [];
      
      foreach ($files["name"] as $fileName) {
        if (empty($fileName)) {
          throw new UploadException(message: "Please select a file to upload.");
        }

        $nameParts = explode(".", $fileName);
        if (end($nameParts) !== 'csv') {
          throw new UnsupportedFileExtensionException(message: "File has wrong extension. Please upload a CSV file.");
        }
      };
      
      foreach ($files["tmp_name"] as $filePath) {
        if ($readResult = $this->readFileContents($filePath)) {
          $multipleFilesContents = array_merge($multipleFilesContents, $readResult);
        };
      }

      return $multipleFilesContents;
    }

    public function uploadTransactionsToDB(array $transactions) : bool {

      $query = "INSERT INTO transactions (date, check_number, description, amount) VALUES (?, ?, ?, ?);";
      $statement = $this->db->prepare($query);

      if (!empty($transactions)) 
      { 
        foreach ($transactions as $transaction) 
        { 
          $formattedTransaction = $this->formatTransactionForDB($transaction);
          $statement->execute(array_values($formattedTransaction));
        }
      }

      return true;
    }

    private function formatTransactionForDB(array $transaction) : array {
      
      try {
        $transaction["date"] = (new DateTime($transaction["date"]))->format("Y-m-d");
      } 
      catch (Exception $e) {
        throw new InvalidFileContentsException(message: "Uploaded file has wrong contents. Please check date column.");
      }

      $transaction["amount"] = str_replace([",", "$"], "", $transaction["amount"]);
      if (!is_numeric($transaction["amount"])) {
        throw new InvalidFileContentsException(message: "Uploaded file has wrong contents. Please check amount column.");
      }
      
      $transaction["check_number"] = (int)($transaction["check_number"]);

      return $transaction;
    }

    private function formatTransactionForView(array $transaction): array {
      $transaction["date"] = (new DateTime($transaction["date"]))->format("M j,Y");
      $transaction["amount"] = (float)$transaction["amount"];

      return $transaction;
    }

    private function calculateTotalIncome(array $transactions) : float {
      $totalIncome = 0;

      $totalIncome = array_sum(
        array_filter(array_column($transactions, "amount"), function ($value) {
          return $value > 0;
        })
      );

      return round($totalIncome, 2);
    }

    private function calculateTotalExpense(array $transactions) : float {
      $totalExpense = 0;

      $totalExpense = array_sum(
        array_filter(array_column($transactions, "amount"), function ($value) {
          return $value < 0;
        })
      );
      
      return round($totalExpense, 2);
    }

    private function calculateNetTotal(array $transactions) : float {
      $netTotal = 0;

      $netTotal = array_sum(array_column($transactions, "amount"));

      return round($netTotal, 2);
    }
}
