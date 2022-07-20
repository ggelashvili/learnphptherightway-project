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
    include __DIR__ . '/../app/helper.php';

    if (isset($transactions)) {
        foreach ($transactions as $transaction) {
            ?>
            <tr>
                <td><?php echo dateFormatter($transaction['date']); ?></td>
                <td><?php echo $transaction['check'] ?></td>
                <td><?php echo $transaction['description'] ?></td>
                <td style=" color: <?php if ($transaction['amount'] > 0) echo "green"; else echo "red"; ?>">
                    <?php
                    echo dollarFormatter($transaction['amount']);
                    ?>
                </td>
            </tr>

            <?php
        }
    ?>

    </tbody>
    <tfoot>
    <tr>
        <th colspan="3">Total Income:</th>
        <td><?php
            echo dollarFormatter(getIncome($transactions));
            ?></td>
    </tr>
    <tr>
        <th colspan="3">Total Expense:</th>
        <td>
            <?php
            echo dollarFormatter(getExpense($transactions));
            ?>
        </td>
    </tr>
    <tr>
        <th colspan="3">Net Total:</th>
        <td>
            <?php
            echo dollarFormatter(getIncome($transactions) - getExpense($transactions));
            } ?>
        </td>
    </tr>
    </tfoot>
</table>
</body>
</html>
