<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Upload</title>
</head>
<body>
<form action="/processTransaction" method="post" enctype="multipart/form-data">
    <input type="file" name="transactionsFile" id="transactionsFile">
    <button>Submit</button>
</form>
</body>
</html>