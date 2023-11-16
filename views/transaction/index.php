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

            <?php if (!empty($transactions)): ?>

            <?php foreach ($transactions as $transaction): ?>
                <tr>
                    <th scope="row"><?= \App\Models\Transaction::parseDate($transaction['date']) ?></th>
                    <td><?= $transaction['check_num'] ?></td>
                    <td><?= $transaction['description'] ?></td>

                    <?php if ($transaction['amount'] < 0): ?>
                        <td style="color: red"><?= \App\Models\Transaction::parseAmount($transaction['amount']) ?></td>
                    <?php else: ?>
                        <td style="color: green"><?= \App\Models\Transaction::parseAmount($transaction['amount']) ?></td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3">Total Income:</th>
                    <td><?= $totals['expenses'] ?></td>
                </tr>
                <tr>
                    <th colspan="3">Total Expense:</th>
                    <td><?= $totals['incomes'] ?></td>
                </tr>
                <tr>
                    <th colspan="3">Net Total:</th>
                    <td><?= $totals['net'] ?></td>
                </tr>
            </tfoot>

            <?php else: ?>
                <p style="text-align: center">
                    Not transactions found,
                    <a href="/transactions/create">Try upload some first !</a>
                </p>
            <?php endif; ?>
        </table>
    </body>
</html>
