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
        <?php if(!empty($data["transactions"])): ?>
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
                <?php if (!empty($data)): ?>
                  <?php foreach($data["transactions"] as $transaction): ?>
                    <tr>
                      <!-- Display logic -->
                      <td><?= htmlspecialchars($transaction["date"]) ?></td>
                      <td>
                        <?= ($transaction["check_number"] === 0) ? "" : htmlspecialchars($transaction["check_number"]); ?>
                      </td>
                      <td><?= htmlspecialchars($transaction["description"]) ?></td>
                      <td
                        <?php if ($transaction["amount"] > 0): ?> 
                          style='color: green;'
                        <?php elseif ($transaction["amount"] < 0): ?>
                          style='color: red;'
                        <?php endif; ?>
                      > 
                      <?php if($transaction["amount"] >= 0): ?>
                        $<?= htmlspecialchars($transaction["amount"]); ?> 
                      <?php else: ?> 
                        -$<?= htmlspecialchars(abs($transaction["amount"])); ?> 
                      <?php endif; ?>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3">Total Income:</th>
                    <td>
                      $<?= htmlspecialchars($data["totalIncome"]);?>
                    </td>
                </tr>
                <tr>
                    <th colspan="3">Total Expense:</th>
                    <td>
                      -$<?= htmlspecialchars(abs($data["totalExpense"]));?>
                    </td>
                </tr>
                <tr>
                    <th colspan="3">Net Total:</th>
                    <td>
                      $<?= htmlspecialchars($data["netTotal"]);?>
                    </td>
                </tr>
            </tfoot>
        </table>
        <?php else: ?>
          <p>No transactions were added yet.</p>
        <?php endif ?>
    </body>
</html>
