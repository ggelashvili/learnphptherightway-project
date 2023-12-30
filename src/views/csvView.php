<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <?php if(count($data)): ?>
            <table class="table">
                <thead>
                <tr>
                    <?php foreach ($headers as $header): ?>
                        <th scope="col">
                            <?= $header ?>
                        </th>
                    <?php endforeach; ?>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($data as $row): ?>
                    <tr>
                        <td><?= formatDate($row[0]) ?></td>
                        <td><?= $row[1] ?></td>
                        <td><?= $row[2] ?></td>
                        <td style="color: <?= getMoneyColor($row[3]) ?>"><?= $row[3] ?></td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td></td>
                    <td></td>
                    <th>Total Income:</th>
                    <td><?= formatMoney($moneyDetails['totalIncome']) ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <th>Total Expense:</th>
                    <td><?= formatMoney($moneyDetails['totalExpense']) ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <th>Net Total:</th>
                    <td><?= formatMoney($moneyDetails['netTotal']) ?></td>
                </tr>
                </tbody>
            </table>
        <?php else: ?>
            <div class="mt-5">
                <h1 class="text-center">No Data available.</h1>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
