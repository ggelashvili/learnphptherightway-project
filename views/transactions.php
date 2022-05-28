<?php
    function formatDollarAmount(float $amount): string
    {
        $isNegative = $amount < 0;

        return ($isNegative ? '-' : '') . '$' . number_format(abs($amount), 2);
    }

    function formatDate(string $date): string
    {
        return date('M j, Y', strtotime($date));
    }
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
            <?php foreach ($transactions as $transaction): ?>
            <tr>
                <td><?= formatDate($transaction['date']) ?></td>
                <td><?= $transaction['check_number'] ?></td>
                <td><?= $transaction['description'] ?></td>
                <td>
                    <?php if ($transaction['amount'] < 0): ?>
                        <span style="color:red">
                            <?= formatDollarAmount($transaction['amount']) ?>
                        </span>
                    <?php elseif ($transaction['amount'] > 0): ?>
                        <span style="color:green">
                            <?= formatDollarAmount($transaction['amount']) ?>
                        </span>
                    <?php else: ?>
                        <?= formatDollarAmount($transaction['amount']) ?>
                    <?php endif ?>
                </td>
            </tr>
            <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3">Total Income:</th>
                    <td><?= formatDollarAmount($total_income) ?></td>
                </tr>
                <tr>
                    <th colspan="3">Total Expense:</th>
                    <td><?= formatDollarAmount($total_expense) ?></td>
                </tr>
                <tr>
                    <th colspan="3">Net Total:</th>
                    <td><?= formatDollarAmount($total_income + $total_expense) ?></td>
                </tr>
            </tfoot>
        </table>
        <form action="/transactions/upload" method="post" enctype="multipart/form-data">
            <input type="hidden" name="MAX_FILE_SIZE" value="30000" />
            <label for="transactions-file">Upload transactions:</label>
            <br>
            <input name="transactions-file[]" type="file" accept="text/csv" multiple>
            <br>
            <br>
            <input type="submit" value="Upload">
        </form>
    </body>
</html>
