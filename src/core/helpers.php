<?php

/* Require files helpers. */
function basePath(string $path): string {

    return BASE_PATH . $path;
}

function config($path): mixed {

    return require_once basePath('config/'. $path);
}

function view(string $path, array $data = []): void {

    extract($data);

    require basePath('views/' . $path);
}


/* Presentation helpers */
function formatDate(string $date): bool|string {

    $date = new DateTime($date);

    return date_format($date, 'M d, Y');
}

function getMoneyColor(string $money): string {

    return $money[0] === '-' ? 'red' : 'green';
}

function formatMoney(int $money): string {

    $moneyStr = '';

    if($money < 0) $moneyStr .= '-';

    $moneyStr.= '$'. abs($money);

    return $moneyStr;
}

function getMoneyDetails(array $data): array {

    $totalExpense = 0;
    $totalIncome = 0;

    foreach ($data as $row) {

        $money = convertToNumber($row[3]);

        if($money < 0) $totalExpense += $money;
        else $totalIncome += $money;
    }

    $netTotal = ($totalIncome - abs($totalExpense));

    return [
        'totalExpense' => $totalExpense,
        'totalIncome' => $totalIncome,
        'netTotal' => $netTotal
    ];
}

function convertToNumber(string $money): int {

    if($money[0] === '-') {

        return (int)substr($money, 2) * -1;
    }

    return (int)substr($money, 1);
}


/* Files helpers. */
function validateFile(string $fileName): bool {

    return file_exists(basePath($fileName));
}

function getCsvFilesContent(array $files): array  {

    $data = [];

    foreach ($files as $file) {

        $f = fopen(basePath($file['file']), 'r');
        fgetcsv($f);

        while($line = fgetcsv($f, 0, $file['delimiter'])) {

            $data[] = $line;
        }

        fclose($f);
    }

    return $data;
}

/* Error helpers */
function abort(string $message): void {

    echo $message;
    exit();
}
