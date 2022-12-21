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
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($transactions) {
                    foreach ($transactions as $transaction) { ?>
                        <tr>
                            <td><?php echo $commonHelper->dateFormat($transaction['date'], 'Y-m-d', 'M j, Y'); ?></td>
                            <td><?php echo htmlspecialchars($transaction['check_no'], ENT_QUOTES); ?></td>
                            <td><?php echo htmlspecialchars($transaction['description'], ENT_QUOTES); ?></td>
                            <td>
                                <?php if ($transaction['amount'] >= 0) { ?>
                                    <span style="color: green;"><?php echo $commonHelper->currency($transaction['amount']); ?></span>
                                <?php } else { ?>
                                    <span style="color: red;"><?php echo $commonHelper->currency($transaction['amount']); ?></span>
                                <?php } ?>
                            </td>
                            <td><a href="/transaction/delete?id=<?php echo $transaction['id']; ?>">Delete</a></td>
                        </tr>
                    <?php }
                    } else {
                        echo '<tr><td colspan="4">No records found <br/>
                        <a href="/">Add</a>
                        </td></tr>';
                    } ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3">Total Income:</th>
                    <td><?php echo $totals['totalIncome']; ?></td>
                </tr>
                <tr>
                    <th colspan="3">Total Expense:</th>
                    <td><?php echo $totals['totalExpense']; ?></td>
                </tr>
                <tr>
                    <th colspan="3">Net Total:</th>
                    <td><?php echo $totals['netTotal']; ?></td>
                </tr>
            </tfoot>
        </table>
    </body>
</html>
