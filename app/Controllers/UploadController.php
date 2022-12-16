<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\TransactionModel;

class UploadController
{
    public function upload(): void
    {
        $fileName = 'transaction_file';
        $files = $_FILES[$fileName];

        $count = count($_FILES['transaction_file']['name']);

        for ($i = 0; $i < $count; ++$i) {
            if (0 == $files['error'][$i]) {
                $filePath = STORAGE_PATH.'/'.$files['name'][$i];

                move_uploaded_file($files['tmp_name'][$i], $filePath);
                $_SESSION['success_msg'] = ($i + 1).' file(s) uploaded successfully.';

                $transactions = $this->scanFileByPath($filePath);

                $this->save($transactions);
                header('location: /transactions');
            } else {
                $_SESSION['error_msg'] = $files['name'][$i].' file upload error.';
                header('location: /');
            }
        }
    }

    protected function save(?array $transactions): void
    {
        $transactionModel = new TransactionModel();

        if ($transactions) {
            foreach ($transactions as $transaction) {
                $transactionModel->create($transaction);
            }
        }
    }

    protected function scanAllFiles(): void
    {
        $path = STORAGE_PATH.'/';

        $allFilesTransactions = [];
        foreach (glob($path.'*.csv') as $file) {
            $allFilesTransactions[] = $this->scanFileByPath($file);
        }

        foreach ($allFilesTransactions as $transactions) {
            $this->save($transactions);
        }
    }

    protected function scanFileByPath($filePath): array
    {
        $csvData = $this->csv_in_array($filePath, ';', '"', false);

        return $this->parseData($csvData);
    }

    protected function parseData(array $csvData): array
    {
        $resultData = [];
        if (count($csvData) > 1) {
            unset($csvData[0]);
            $csvData = array_values($csvData);

            foreach ($csvData as $val) {
                $array = explode(',', $val[0]);
                $data['date'] = $this->dateFormat($array[0]);
                $data['check'] = $array[1];
                $data['description'] = $array[2];
                $data['amount'] = str_replace('$', '', $array[3]);
                $resultData[] = $data;
            }
        }

        return $resultData;
    }

    protected function dateFormat(string $date, string $inputFormat = 'm/d/Y', string $returnFormat = 'Y-m-d')
    {
        $dateObj = \DateTime::createFromFormat($inputFormat, $date);
        if (!$dateObj) {
            throw new \UnexpectedValueException("Could not parse the date: {$date}");
        }

        return $dateObj->format($returnFormat);
    }

    protected function csv_in_array($url, $delm = ';', $encl = '"', $head = false)
    {
        $csvxrow = file($url);   // ---- csv rows to array ----

        $csvxrow[0] = chop($csvxrow[0]);
        $csvxrow[0] = str_replace($encl, '', $csvxrow[0]);
        $keydata = explode($delm, $csvxrow[0]);
        $keynumb = count($keydata);

        if (true === $head) {
            $anzdata = count($csvxrow);
            $z = 0;
            for ($x = 1; $x < $anzdata; ++$x) {
                $csvxrow[$x] = chop($csvxrow[$x]);
                $csvxrow[$x] = str_replace($encl, '', $csvxrow[$x]);
                $csv_data[$x] = explode($delm, $csvxrow[$x]);
                $i = 0;
                foreach ($keydata as $key) {
                    $out[$z][$key] = $csv_data[$x][$i];
                    ++$i;
                }
                ++$z;
            }
        } else {
            $i = 0;
            foreach ($csvxrow as $item) {
                $item = chop($item);
                $item = str_replace($encl, '', $item);
                $csv_data = explode($delm, $item);
                for ($y = 0; $y < $keynumb; ++$y) {
                    $out[$i][$y] = $csv_data[$y];
                }
                ++$i;
            }
        }

        return $out;
    }
}
