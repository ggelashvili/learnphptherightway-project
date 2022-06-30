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
    foreach ($this->transactions as $transaction) { ?>
    <tr>
        <td> <?= $transaction->getDate()->format('d.m.Y') ?> </td>
        <td> <?= $transaction->getCheck() ?></td>
        <td> <?= $transaction->getDescription() ?></td>
        <td style="color: <?= $transaction->getAmount() > 0 ? 'green' : 'red'?> "> <?= \App\Models\Transaction::currencyFormatter($transaction->getAmount()) ?></td>
    </tr>
    <?php } ?>
    </tbody>
    <tfoot>
    <tr>
        <th colspan="3">Total Income:</th>
        <td><?= \App\Models\Transaction::currencyFormatter($this->totalIncome) ?></td>
    </tr>
    <tr>
        <th colspan="3">Total Expense:</th>
        <td><?= \App\Models\Transaction::currencyFormatter($this->totalExpense) ?></td>
    </tr>
    <tr>
        <th colspan="3">Net Total:</th>
        <td><?= \App\Models\Transaction::currencyFormatter($this->netTotal) ?></td>
    </tr>
    </tfoot>
</table>
</body>
</html>
