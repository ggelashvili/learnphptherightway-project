<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Config;
use App\Models\Transaction;
use App\View;

class UploadController
{
    private Config $config;

    public function __construct(){
        $this->config = new Config($_ENV);
    }
    public function index(): View
    {
        return View::make('index');
    }

    public function upload(): void
    {
        $filesUpload = $_FILES['receipt'];
        if (is_null($filesUpload)) {
            echo 'Please select a file';
            die();
        }
        for ($i = 0; $i < count($filesUpload['name']); $i++) {
            $filename = $filesUpload['name'][$i];
            $fileTmpName = $filesUpload['tmp_name'][$i];
            if (is_null($fileTmpName) || $fileTmpName === '') {
                // header('location: /');
                echo 'Please select a file';
            }

            $fileSize = $filesUpload['size'][$i];
            $max_upload_file_size = 3 * 1024 * 1024;
            if ($fileSize > $max_upload_file_size) {
                // header('location: /');
                echo 'File size is too large';
            }

            $allowedMimeTypes = ['text/csv'];
            $fileMimeType = mime_content_type($fileTmpName);
            if (!in_array($fileMimeType, $allowedMimeTypes)) {
                // header('location: /');
                echo 'File type is not allowed';
            }

            $filePath = STORAGE_PATH . '/' . $filename;
            
            move_uploaded_file($fileTmpName, $filePath);
            
            $file = fopen($filePath, 'r');
            fgetcsv($file);

            $transaction = new Transaction($this->config);

            while (($row = fgetcsv($file)) !== false) {
                $trnx_date = date("Y-m-d", strtotime($row[0]));
                $amount = str_replace('$', '', $row[3]);
                $amount = floatval(str_replace(',', '', $amount));

                $data = [
                    'trnx_date' => $trnx_date,
                    'chk_num' => $row[1],
                    'trnx_desc' => $row[2],
                    'trnx_amt' => $amount
                ];

                $transaction->insert($data);
            }
        }
        header('location: /transactions');
    }

    public function display(): View
    {
        $trnx = new Transaction($this->config);
        $trnx_data = $trnx->get();
        foreach ($trnx_data as $key => $value) {
            $trnx_data[$key]['transaction_date'] = date('M j, Y', strtotime($value['transaction_date']));
        }

        return View::make(
            'transactions',
            ['trnxs' => $trnx_data]
        );
    }
}