<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Upload new transaction</title>
        <style>
          * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
          }
          .container {
            max-width: 1140px;
            margin: 0 auto;
          }
          .transactions {
            padding-top: 30px;
          }
          .transactions > * {
            text-align: center;
          }
          .transactions__title {
            text-align: center;
            font-size: 28px;
            line-height: 36px;
          }
          .links__list {
            display: block;
            text-align: center;
            list-style: none;
            margin-top: 20px;
          }
          .links__list-item + .links__list-item {
            margin-top: 10px;
          } 
          .links__list-link {
            font-size: 20px;
            text-decoration: none;
            color: #434343;
            transition: all ease-in 0.325s;
          }
          .links__list-link:hover {
            color: #3490d7;
          }
          .transaction-form__submit {
            margin-top: 15px;
          }
          .transaction__error {
            color: red;
            font-size: 18px;
            line-height: 24px;
            margin-top: 20px;
          }
        </style>
    </head>
    <body>
        <div class="container">
           <section class="transactions">
            <h1 class="transactions__title">
              Upload new transactions
            </h1>
            <form class="transactions-form" action="/transactions/upload" enctype='multipart/form-data' method="POST">
              <input type="file"
              id="transaction" name="transactions[]" multiple
              accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
              <button class="transaction-form__submit" type="submit" >Upload</button>
            </form>
            <?php if (isset($error)): ?>
              <p class="transaction__error"><?= $error; ?></p>
            <?php endif; ?>
           </section>
        </div>
    </body>
</html>
