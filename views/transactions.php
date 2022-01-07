<!DOCTYPE html>
<html lang="en">
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
    <?php foreach ($transactions as $key => $transaction): ?>
        <tr>
            <td><?= htmlspecialchars($transaction['date']) ?></td>
            <td><?= htmlspecialchars($transaction['check #']) ?></td>
            <td><?= htmlspecialchars($transaction['description']) ?></td>
            <td style="color: <?= $transaction['amount'] > 0 ? 'green' : 'red' ?>">
                <?= htmlspecialchars($transaction['amount']) ?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
    <tfoot>
    <tr>
        <th colspan="3">Total Income:</th>
        <td><?= htmlspecialchars($total['totalIncome']) ?></td>
    </tr>
    <tr>
        <th colspan="3">Total Expense:</th>
        <td><?= htmlspecialchars($total['totalExpense']) ?></td>
    </tr>
    <tr>
        <th colspan="3">Net Total:</th>
        <td><?= htmlspecialchars($total['netTotal']) ?></td>
    </tr>
    </tfoot>
</table>
<form action="/transactions" method="post" enctype="multipart/form-data">
    <input type="file" name="table">
    <input type="submit">
</form>
</body>
</html>
