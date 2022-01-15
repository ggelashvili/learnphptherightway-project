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
                <?php foreach($transactions as $transaction): ?>
                    <tr>
                        <td><?= $transaction['created_date']?></td>
                        <td><?= $transaction['check_number']?></td>
                        <td><?= $transaction['description']?></td>
                        <td style= <?php echo "color:" . $transaction['color'];?>>
                            <?= $transaction['amount']?>
                        </td>
                    </tr>
                    
                <?php endforeach?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3">Total Income:</th>
                    <td><?= $totalIncome ?></td>
                </tr>
                <tr>
                    <th colspan="3">Total Expense:</th>
                    <td><?= $totalExpenses ?></td>
                </tr>
                <tr>
                    <th colspan="3">Net Total:</th>
                    <td><?= $netTotal ?></td>
                </tr>
            </tfoot>
        </table>

        <form action = "/addtransactions" method="post" enctype="multipart/form-data">
            <input type="file" name="csv_file" />
            <button type="submit">Upload CSV</button>
        </form>
    </body>
</html>
