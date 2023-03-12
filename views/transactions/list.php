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

                use App\Utilities\Currency;
                use App\Utilities\DateTime;

            ?>
            <?php foreach ($transactions as $transaction) : ?>
                    <tr>
                        <td><?= DateTime::formatDate($transaction['date']) ?></td>
                        <td><?= $transaction['checkNumber'] ?></td>
                        <td><?= $transaction['description'] ?></td>
                        <td>
                            <?php if ($transaction['amount'] < 0) : ?>
                                <span style="color: red;">
                                    <?= Currency::formatDollarAmount($transaction['amount']) ?>
                                </span>
                            <?php elseif ($transaction['amount'] > 0) : ?>
                                <span style="color: green;">
                                    <?= Currency::formatDollarAmount($transaction['amount']) ?>
                                </span>
                            <?php else : ?>
                                <?= Currency::formatDollarAmount($transaction['amount']) ?>
                            <?php endif ?>
                        </td>
                    </tr>
            <?php endforeach ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3">Total Income:</th>
                    <td><?= Currency::formatDollarAmount($totals['totalIncome']) ?></td>
                </tr>
                <tr>
                    <th colspan="3">Total Expense:</th>
                    <td><?= Currency::formatDollarAmount($totals['totalExpense']) ?></td>
                </tr>
                <tr>
                    <th colspan="3">Net Total:</th>
                    <td><?= Currency::formatDollarAmount($totals['netTotal']) ?></td>
                </tr>
            </tfoot>
        </table>
    </body>
</html>
