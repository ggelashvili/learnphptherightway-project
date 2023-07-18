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
            <tbody>
                <?php
                $total_income = 0;
                $total_Expense = 0;
                foreach (read_csv_files(FILES_PATH) as $files) 
                {
                    foreach ($files as $ar)
                    {
                        echo "<tr>
                        <td>{$ar['Date']}</td>
                        <td>{$ar['Check #']}</td>
                        <td>{$ar['Description']}</td>";
                        $num = str_replace(["$", ","],'',$ar["Amount"]);
                        if ($num > 0)
                        {
                            echo "<td style='color: green;'>{$ar["Amount"]}</td>";
                            $total_income += $num; 
                        }
                        else 
                        {
                            echo "<td style='color: red;''>{$ar["Amount"]}</td>";
                            $total_Expense += $num;
                        }
                        echo "</tr>";
                    }
                }
                ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3">Total Income:</th>
                    <td><?php echo "$" . number_format($total_income, 2) ?></td>
                </tr>
                <tr>
                    <th colspan="3">Total Expense:</th>
                    
                    <td><?php echo "-" . str_replace("-", "$",(string) number_format($total_Expense, 2)) ?></td>
                </tr>
                <tr>
                    <th colspan="3">Net Total:</th>
                    <td><?php echo "$" . number_format($total_income + $total_Expense, 2) ?></td>
                </tr>
            </tfoot>
        </table>
    </body>
</html>
