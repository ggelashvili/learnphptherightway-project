<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Homepage</title>
        <style>
          .links {
            padding-top: 30px;
          }
          .links__title {
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
        </style>
    </head>
    <body>
        <div class="container">
           <section class="links">
             <h1 class="links__title">Home Page</h1>
              <ul class="links__list">
                <li class="links__list-item">
                  <a href="/transactions/upload" class="links__list-link">Add transactions</a>
                </li>
                <li class="links__list-item">
                  <a href="/transactions" class="links__list-link">View all transactions</a>
                </li>
              </ul>
           </section>
        </div>
    </body>
</html>
