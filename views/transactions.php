<!DOCTYPE html>
<html lang="">
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

    $formatter    = new \App\Ui\UsdCurrencyFormatter();
    $transactions = (new \App\Ui\TransactionFormatter())->format(
        $transactions ?? ''
    );
    foreach ($transactions as $transaction): ?>
        <tr>
            <td><?= $transaction['date'] ?></td>
            <td><?= $transaction['checkedNumber'] ?></td>
            <td><?= $transaction['description'] ?></td>
            <td style="color: <?= str_starts_with($transaction['amount'], '-')
                ? 'red' : 'green' ?>"><?= $transaction['amount'] ?></td>
        </tr>
    <?php
    endforeach; ?>
    </tbody>
    <tfoot>
    <tr>
        <th colspan="3">Total Income:</th>
        <td><?= $formatter->format($totalIncome ?? 0) ?></td>
    </tr>
    <tr>
        <th colspan="3">Total Expense:</th>
        <td><?= $formatter->format($totalExpense ?? 0) ?></td>
    </tr>
    <tr>
        <th colspan="3">Net Total:</th>
        <td><?= $formatter->format($netTotal ?? 0) ?></td>
    </tr>
    </tfoot>
</table>
</body>
</html>
