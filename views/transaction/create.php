<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Expenses - List</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</head>
<body>
<div class="container mt-5">

    <form method="POST"
          action="/transactions/create"
          enctype="multipart/form-data"
    >
        <div class="mb-3">
            <label for="invoiceFile" class="form-label">Select invoice file to upload</label>
            <input class="form-control" type="file" accept="text/csv" name="file" id="invoiceFile">
        </div>

        <div class="mb-3">
            <button class="btn btn-primary w-100" type="submit">Submit</button>
        </div>
    </form>

</div>
</body>
</html>