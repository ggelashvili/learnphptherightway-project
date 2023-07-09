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
      <?php if (! empty($result)): ?>
        <?php foreach($result as $trans): ?>
            <tr>
                <td><?= App\View::date__format($trans['t_Date'])?></td>
                <td><?= $trans['check_num']?></td>
                <td><?= $trans['description']?></td>
                <?php   $color= ($trans['amount']>0) ?'green;':($trans['amount']<0 ?'red;':'blue;') ?>
                <td><span style="color:<?= $color ?>" ><?= App\View::dollar_format($trans['amount'])?></span></td>
            </tr>

        <?php endforeach ?>
    <?php endif ?>
    <tfoot>
    <tr>
        <th colspan="3">Total Income:</th>
        <?php   $color= ($result[0]['income']>0) ?'green;':($result[0]['income']<0 ?'red;':'blue;') ?>
        <td><span style="color:<?= $color ?>" ><?= App\View::dollar_format($result[0]['income'])?></span></td>

    </tr>
    <tr>
        <th colspan="3">Total Expense:</th>
        <?php   $color= ($result[0]['expense']>0) ?'green;':($result[0]['expense']<0 ?'red;':'blue;') ?>
        <td><span style="color:<?= $color ?>" ><?= App\View::dollar_format($result[0]['expense'])?></span></td>
    </tr>
    <tr>
        <th colspan="3">Net Total:</th>
        <?php   $color= ($result[0]['net_total']>0) ?'blue;':($result[0]['net_total']<0 ?'red;':'black;') ?>
        <td><span style="color:<?= $color ?>" ><?= App\View::dollar_format($result[0]['net_total'])?></span></td>
    </tr>
    </tfoot>
</table>
</body>
</html>