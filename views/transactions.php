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
                <!-- TODO -->
                <?php foreach ($transactions as $td) : ?>
                <tr>
                    <?php foreach ($td as $t => $v) : ?>
                        <td style=<?php if ($t == 'amount' && $v[0] == '-') {
                                        echo '"color:red;"';
                                    } elseif($t== 'amount') echo 'color:green' ?>>
                            <?php print_r($v); ?>
                        </td>
                    <?php endforeach ?>
                </tr>

                <?php echo "</tr>"  ?>

            <?php endforeach ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3">Total Income:</th>
                    <td><!-- TODO --></td>
                </tr>
                <tr>
                    <th colspan="3">Total Expense:</th>
                    <td><!-- TODO --></td>
                </tr>
                <tr>
                    <th colspan="3">Net Total:</th>
                    <td><!-- TODO --></td>
                </tr>
            </tfoot>
        </table>
    </body>
</html>
