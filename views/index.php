<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Document</title>
    </head>
    <body>
        <h1>Home Page</h1>
        <div>
            <form method="post" action="/transactions/create" enctype="multipart/form-data">
                <input type="file" name="transactions"><br><br>
                <input type="submit" name="submit" value="upload">
            </form>
        </div>
    </body>
</html>
