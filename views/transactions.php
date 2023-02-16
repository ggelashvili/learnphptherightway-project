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
            .green {
              color: green;
            }
            .red {
              color: red;
            }
        </style>
    </head>
    <body>
        <a href="/">Back home</a>
        
          
          <form action="/transactions/upload" method="post" enctype="multipart/form-data">
          <fieldset>
          <legend>Upload transactions</legend>
            <input type="file" name="transactions[]" id="transactions" multiple>
            <input type="submit" value="Upload">
          </fieldset>
          </form>
        

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
                    <td><?= $helper->dateFormat($transaction['date']) ?></td>
                    <td><?= $transaction['checking'] ?></td>
                    <td><?= $transaction['description'] ?></td>
                    <td class="<?= $transaction['amount'] > 0 ? 'green' : 'red' ?>"><?= $helper->amountFormat($transaction['amount']) ?></td>
                  </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3">Total Income:</th>
                    <td><?= $helper->amountFormat($totals['income']) ?></td>
                </tr>
                <tr>
                    <th colspan="3">Total Expense:</th>
                    <td><?= $helper->amountFormat($totals['expense']) ?></td>
                </tr>
                <tr>
                    <th colspan="3">Net Total:</th>
                    <td><?= $helper->amountFormat($totals['net']) ?></td>
                </tr>
            </tfoot>
        </table>
    </body>
</html>
