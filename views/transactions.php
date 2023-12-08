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
            <?foreach ($processedTransaction->getTransactions() as $transaction):?>
                   <tr>
                    <td><?= $transaction->date->format('M j,Y')?></td>
                    <td><?= $transaction->check?></td>
                    <td><?= $transaction->description?></td>
                    <td style="color: <?=  $transaction->amount > 0 ? 'green' : 'red' ?>;" >
                        <?= formatMoney($transaction->amount)?>
                    </td>
                   </tr> 
                <?endforeach?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3">Total Income:</th>
                    <td><?= formatMoney($processedTransaction->getTotalIncome()) ?></td>
                </tr>
                <tr>
                    <th colspan="3">Total Expense:</th>
                    <td><?= formatMoney($processedTransaction->getTotalExpense()) ?></td>
                </tr>
                <tr>
                    <th colspan="3">Net Total:</th>
                    <td><?= formatMoney($processedTransaction->getNetTotal()) ?></td>
                </tr>
            </tfoot>
        </table>
    </body>
</html>