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
            <td><?= $transaction['date'] ?></td>
            <td><?= $transaction['check #'] ?></td>
            <td><?= $transaction['description'] ?></td>
            <td><?= $transaction['amount'] ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
    <tfoot>
    <tr>
        <th colspan="3">Total Income:</th>
        <td><?= $total['totalIncome'] ?></td>
    </tr>
    <tr>
        <th colspan="3">Total Expense:</th>
        <td><?= $total['totalExpense'] ?></td>
    </tr>
    <tr>
        <th colspan="3">Net Total:</th>
        <td><?= $total['netTotal'] ?></td>
    </tr>
    </tfoot>
</table>
<form action="/transactions" method="post" enctype="multipart/form-data">
    <input type="file" name="table">
    <input type="submit">
</form>
</body>
</html>
