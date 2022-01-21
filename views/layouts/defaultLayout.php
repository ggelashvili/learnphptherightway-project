<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }
    .container {
      max-width: 1140px;
      padding: 0 15px;
      margin: 0 auto;
    }
    .header {
      background-color: #282A35;
      padding: 0 20px;
      margin: 0;
    }
    .header__item {
      display: inline-block;
      margin: 0;
    }
    .header__item + .header__item {
      margin-left: 10px;
    }
    .header__item-link {
      display: inline-block;
      font-family: "Arial";
      color: #fff;
      text-decoration: none;
      padding: 10px 5px;
      font-size: 16px;
      line-height: 24px;
      transition: all 0.3s;
    }
    .header__item-link:hover {
      color: indianred;
    }
  </style>
</head>
<body>
  <div class="header">
    <div class="container">
      <div class="header__inner">
        <ul class="header__items">
          <li class="header__item">
            <a class="header__item-link" href="/">Homepage</a>
          </li>
          <li class="header__item">
            <a class="header__item-link" href="/transactions">Transactions</a>
          </li>
          <li class="header__item">
            <a class="header__item-link" href="/transactions/upload">Upload Transactions</a>
          </li>
        </ul>
      </div>
    </div>
  </div>
  <div class="container">
    {{contentPlaceholder}}
  </div>
</body>
</html>
