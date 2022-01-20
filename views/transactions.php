<?php

use App\Models\Transaction;

/**
 * @var Transaction[] $transactions
 * @var float $income
 * @var float $expense
 */
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
    <tbody>
		<?php
		foreach ($transactions as $transaction) : ?>
        <tr>
            <td><?php echo $transaction->getDate()->format('M d, Y') ?></td>
            <td><?php echo $transaction->getCheck() ?></td>
            <td><?php echo $transaction->getDescription() ?></td>
            <td style="color: <?php echo $transaction->getAmount() < 0 ? "red" : "green" ?>">
							<?php echo Transaction::getFormattedAmount($transaction->getAmount()) ?>
            </td>
        </tr>
		<?php endforeach; ?>
    </tbody>
    <tfoot>
    <tr>
        <th colspan="3">Total Income:</th>
        <td><?php echo Transaction::getFormattedAmount($income) ?></td>
    </tr>
    <tr>
        <th colspan="3">Total Expense:</th>
        <td><?php echo Transaction::getFormattedAmount($expense) ?></td>
    </tr>
    <tr>
        <th colspan="3">Net Total:</th>
        <td><?php echo Transaction::getFormattedAmount($income + $expense) ?></td>
    </tr>
    </tfoot>
</table>
</body>
</html>
