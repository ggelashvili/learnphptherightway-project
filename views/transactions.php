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
                    foreach($data as $row)
                    {
                        if ($row["amount"] > 0)
                        {
                            $color = "green";
                            $row["amount"] = "$" . (string) $row["amount"];
                        }
                        else
                        {
                            $color = "red";
                            $row["amount"] = str_replace("-", "-$", (string) $row["amount"]);
                        }
                        $html = <<<text
                            <tr>
                                <td>{$row['date']}</td>
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
                    <td><?php echo $total_income?></td>
                </tr>
                <tr>
                    <th colspan="3">Total Expense:</th>
                    <td><?php echo $total_expense?></td>
                </tr>
                <tr>
                    <th colspan="3">Net Total:</th>
                    <td><?php echo $net_total?></td>
                </tr>
            </tfoot>
        </table>
    </body>
</html>
