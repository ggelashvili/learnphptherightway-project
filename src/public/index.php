<?php

declare(strict_types=1);

require_once '../core/helpers.php';

define('BASE_PATH', __DIR__ . '/../');


$files = config('csvFiles.php');
$headers  = config('csvHeaders.php');

/* Validate the existence of each file. */
foreach ($files as $file) {

    if(!validateFile($file['file'])) {

        abort("Some files does not exist !");
    }
}



$data = getCsvFilesContent($files);
$moneyDetails = getMoneyDetails($data);

view('csvView.php', [
    'headers' => $headers,
    'moneyDetails' => $moneyDetails,
    'data' => $data
]);
