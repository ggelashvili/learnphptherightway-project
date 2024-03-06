<?php

declare(strict_types = 1);

function readCsv (): array{
    $csvFile = fopen('../transaction_files/sample_1.csv', "r");
    while ((($file = fgetcsv($csvFile, 100, ',')) !== false)) {
        $array[] = $file;
    }
    fclose($csvFile);
    unset($array[0]);
    return $array;
}

function calculateTotalIncome (array $csvArray): array
{
    $totalIncome = 0.0;
    $totalExpense = 0.0;
    foreach ($csvArray as $line){
        $value = (float) str_replace(array("$",","),"",$line[3]);
        if ($value > 0){
            $totalIncome += $value;
        }else{
            $totalExpense += $value;
        }
    }
    $total[0] = $totalIncome;
    $total[1] = $totalExpense * -1;
    return $total;
}

function printDates (array $csvArray): void{

    foreach ($csvArray as $line){
//        $date = date_create ($line[0]);
        echo "<tr>";
        echo "<td>" . date_format(date_create ($line[0]), "M d,Y") . "</td>";
        echo "<td>" . $line[1] . "</td>";
        echo "<td>" . $line[2] . "</td>";
        $amount = (float) str_replace(array("$",","),"",$line[3]);
        if ($amount > 0){
            echo "<td style='color: green'>" . "$" . $amount . "</td>";
        }else{
            echo "<td style='color: red'>" . "-$" .$amount * -1 . "</td>";

        }
        echo "</tr>";


    }

}

