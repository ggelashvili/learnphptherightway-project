<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Application;
use App\Models\Transaction;
use App\View;
use PDO;

class HomeController
{
    public function index(): View
    {

        return View::make('index');
    }


    public function transaction(): View
    {
        $files = $this->get_files(STORAGE_PATH . '/');
        $transactions=[];
        foreach ($files as $file)

            $transactions = array_merge($transactions, $this->get_content($file, [$this, 'Parse_row']));

            $total = $this->process($transactions);

        $trans = new Transaction();

        foreach ($transactions as $transaction) {

         $trans->create($transaction['amount'],
             $transaction['description'], $this->sql_format($transaction['date']), (int)$transaction['check_number'],$total);

        }
          $result=$trans->List();

        return View::make('transaction',['result'=> $result]);
    }

    public function sql_format(string $date): string
    {
        return date('Y-m-d H:i:s', strtotime($date));
    }

    public function get_files(string $path): array
    {
        $files = [];
        foreach (scandir($path) as $file) {
            if (is_dir($file))
                continue;
            else {
                $files[] = $path . $file;
            }
        }
        return $files;
    }

    public function get_content(string $file_name, ?callable $transaction_handler = null): array
    {
        if (!file_exists($file_name))
            trigger_error('FILE "' . $file_name . '" doesnt exists.', E_USER_ERROR);

        $file = fopen($file_name, 'r');

        $transactions = [];

        fgetcsv($file);

        while (($transaction = fgetcsv($file)) !== false) {
            if ($transaction_handler !== null) {
                $transaction = $transaction_handler($transaction);
            }
            $transactions[] = $transaction;
        }
        return $transactions;
    }

   public function Parse_row(array $trans_row): array
    {

        [$date, $check_number, $desc, $amount] = $trans_row;

        $amount = str_replace([',', '$'], '', $amount);
        $amount= (float) number_format(  (float) $amount, 2, '.', '');
        $check_number=(int)$check_number;

        return ['date' => $date, 'check_number' => $check_number, 'description' => $desc, 'amount' => $amount];

    }

    public function process(array $transactions): array
    {
        $total = ['income' => 0, 'expenses' => 0, 'net_total' => 0];

        foreach ($transactions as $transaction) {
            $total['net_total'] += $transaction['amount'];
            $total['net_total']=(float) number_format(  (float) $total['net_total'], 2, '.', '');
            if ($transaction['amount'] >= 0) {
                $total['income'] += $transaction['amount'];
                $total['income']=(float) number_format(  (float) $total['income'], 2, '.', '');
            }
            else {
                $total['expenses'] += $transaction['amount'];
                $total['expenses']=(float) number_format(  (float) $total['expenses'], 2, '.', '');

            }
        }

        return $total;
    }

    public function upload():void
    {
            for ($i = 0; $i < count($_FILES['trans']['name']); $i++) {
                $filepath = STORAGE_PATH . '/' . $_FILES['trans']['name'][$i];
                move_uploaded_file($_FILES['trans']['tmp_name'][$i], $filepath);

            }
        header('Location: /transaction');
        exit;

    }


    public function download(): void
    {
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment;filename="my_pdf.pdf"');
        readfile(STORAGE_PATH . '/PHP-Cheat-Sheet');

    }
}