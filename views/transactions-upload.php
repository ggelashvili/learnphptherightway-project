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

    <h1>transactions-create</h1>
<form action="/MVC-file-parse/transactions/store" enctype="multipart/form-data" method="post">
    <input type="file" name="csvs[]" multiple>
    <button type="submit">submit</button>
</form>
</body>
</html>