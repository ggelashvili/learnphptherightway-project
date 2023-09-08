<!DOCTYPE html>
<html>
    <head>
        <title>Transactions</title>
        <style>
            table {
                font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
                font-size: 1rem;
                width: 100%;
                border-collapse: collapse;
                text-align: center;
                width: 800px;
                margin: 0 auto;
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

            .red,
            .green {
                font-weight: 600;
                color: red;
            }

            .green {
                color: green;
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
                    foreach ($records as $key => $record): ?>
                    <tr>
                        <td><?php echo (new \DateTime($record['date']))->format('M d, Y'); ?></td>
                        <td><?php echo $record['check']; ?></td>
                        <td><?php echo $record['description']; ?></td>
                        <td class="<?php echo $getAmountClass($record['amount']); ?>">
                            <?php echo $formatPrice($record['amount']); ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3">Total Income:</th>
                    <td><?php echo $formatPrice($totalIncome); ?></td>
                </tr>
                <tr>
                    <th colspan="3">Total Expense:</th>
                    <td><?php echo $formatPrice($totalExpense); ?></td>
                </tr>
                <tr>
                    <th colspan="3">Net Total:</th>
                    <td><?php echo $formatPrice($totalIncome + $totalExpense); ?></td>
                </tr>
            </tfoot>
        </table>
    </body>
</html>
