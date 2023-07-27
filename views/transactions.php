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
                    use App\Transaction;
                    require __DIR__ . "/../App/Model.php";
                    $total_income = 0;
                    $total_expense = 0;
                    $net_total = 0;
                    $data = (new transaction)->getData();
                    foreach($data as $row)
                    {
                        $amount = (float) str_replace(["$", ","], '', $row['amount']);
                        $color = '';
                        if ($amount > 0)
                        {
                            $total_income += $amount;
                            $color = "green";
                        }
                        else 
                        {
                            $total_expense += $amount;
                            $color = "red";
                        }
                        $a = date('M j, Y', strtotime($row['date']));
                        $html = <<<text
                            <tr>
                                <td>{$a}</td>
                                <td>{$row['check_']}</td>
                                <td>{$row['description']}</td>
                                <td style="color: {$color};">{$row['amount']}</td>
                            </tr>
                        text;
                        echo $html;
                    }
                ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3">Total Income:</th>
                    <td><?php echo "$" . (string) $total_income?></td>
                </tr>
                <tr>
                    <th colspan="3">Total Expense:</th>
                    <td><?php echo str_replace("-", "-$", (string) $total_expense)?></td>
                </tr>
                <tr>
                    <th colspan="3">Net Total:</th>
                    <td><?php echo "$" . (string)$total_income + $total_expense ?></td>
                </tr>
            </tfoot>
        </table>
    </body>
</html>
