<?php
    $income = 0.0;
    $expense = 0.0;
    foreach($trnxs as $trnx) {
        if ($trnx['transaction_amount'] > 0.0) {
            $income += $trnx['transaction_amount'];
        } else {
            $expense += $trnx['transaction_amount'];
        }
    }

    $total = $income + $expense;
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Transactions</title>
        <link 
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" 
            rel="stylesheet" 
            integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" 
            crossorigin="anonymous"
        >
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
        <main class="container">
            <h1>Transactions</h1>
            <table class="table table-striped">
                <thead class="table-light">
                    <tr>
                        <th>Date</th>
                        <th>Check #</th>
                        <th>Description</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    <?php foreach($trnxs as $trnx): ?>
                        <tr>
                            <td><?= $trnx['transaction_date'] ?></td>
                            <td><?= $trnx['cheque_number'] ?></td>
                            <td><?= $trnx['transaction_description'] ?></td>
                            <td
                                class="<?= $trnx['transaction_amount'] < 0 ? 'text-danger' : 'text-success' ?>"
                            >
                                <?= number_format(abs($trnx['transaction_amount']), 2) ?>
                            </td>
                        </tr
                    <?php endforeach; ?>
                </tbody>
                <tfoot class="table-group-divider">
                    <tr>
                        <th colspan="3">Total Income:</th>
                        <td class="text-success">
                            <?= number_format($income, 2) ?>
                        </td>
                    </tr>
                    <tr>
                        <th colspan="3">Total Expense:</th>
                        <td class="text-danger">
                            <?= number_format(abs($expense), 2) ?>
                        </td>
                    </tr>
                    <tr>
                        <th colspan="3">Net Total:</th>
                        <td><?= number_format($total, 2) ?></td>
                    </tr>
                </tfoot>
            </table>
        </main>
        <script 
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" 
            integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" 
            crossorigin="anonymous"
        ></script>
    </body>
</html>
