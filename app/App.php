<?php

declare(strict_types = 1);

function getCsv($path): array
{
    $array = [];
    $file = fopen($path, "r");
    while (!feof($file)) {
        $array[] = fgetcsv($file);
    }
    fclose($file);
    return $array;
}