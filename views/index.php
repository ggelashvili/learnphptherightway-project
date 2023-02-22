<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta 
            name="viewport"
            content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"
        >
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Upload Transactions</title>
        <link 
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" 
            rel="stylesheet" 
            integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" 
            crossorigin="anonymous"
        >
    </head>
    <body>
        <main class="container">
            <h1>Upload Transactions</h1>
            <form action="/upload" method="post" enctype="multipart/form-data">
                <div class="form-group mb-3">
                    <label for="receipt" class="form-label">Select CSV file</label>
                    <input type="file" id="receipt" name="receipt[]" class="form-control"  multiple/>
                </div>
                <button type="submit" class="btn btn-outline-primary">Upload</button>
            </form>
        </main>
        <script 
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" 
            integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" 
            crossorigin="anonymous"
        ></script>
    </body>
</html>
