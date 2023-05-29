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
        <?php if($this->message): ?>
        <p style="color: <?= $this->msgColor ?>;"><?= $this->message ?> </p>
        <?php endif; ?>
        <form action="/upload" method="post" enctype="multipart/form-data">
            <input name="transactions[]" type="file" multiple />
            <button type="submit">Upload files</button>
        </form>
    </body>
</html>
