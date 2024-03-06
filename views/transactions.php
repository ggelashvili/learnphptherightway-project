<?php
include_once ('../public/index.php');
$csvArray = readCsv();
unset($csvArray[0]);
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Transactions</title>
        <style>
            table {
                width: 100%;
                border-collapse: collapse;
                text-align: center;
            }

            table tr th, table tr td {
                padding: 5px;
                border: 1px #eee solid;
            }

            tfoot tr th, tfoot tr td {
                font-size: 20px;
            }

            tfoot tr th {
                text-align: right;
            }
        </style>
    </head>
    <body>
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Check #</th>
                    <th>Description</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <thead>
            <?php
                printDates($csvArray);
                ?>
            </thead>
            <tfoot>
                <tr>
                    <th colspan="3">Total Income:</th>
                    <td>
                        <p>
                            <?php
                            $total = calculateTotalIncome($csvArray);
                            $totalIncome = $total[0];
                            $totalExpense = $total[1];
                            echo "$" . $totalIncome;
                            ?>
                        </p>
                    </td>
                </tr>
                <tr>
                    <th colspan="3">Total Expense:</th>
                    <td>
                        <?php
                        echo "-" . "$" . $totalExpense;
                        ?>
                    </td>
                </tr>
                <tr>
                    <th colspan="3">Net Total:</th>
                    <td>
                        <?php
                        $totalNet = $totalIncome - $totalExpense;
                        echo "$" . $totalNet;
                        ?>

                    </td>
                </tr>
            </tfoot>
        </table>
    </body>
</html>
