<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">
<div class="h-100 w-100 d-flex align-items-center justify-content-center">
    <div class="text-center border py-4 px-2 d-flex flex-column align-items-center justify-content-center shadow">
        <h3 class="text-capitalize mb-4">upload csv file</h3>
        <form action="/upload" method="post" enctype="multipart/form-data" class="d-flex flex-column justify-content-between align-items-center">
            <input type="file" name="csv" id="" class="form-control mb-3">
            <button type="submit" class="btn btn-success">Upload</button>
        </form>
    </div>
</div>