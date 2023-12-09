<form action='/transactions/upload' method='post' enctype="multipart/form-data">
    <div>
        <label for='files'>Upload Transaction:</label>
        <input type='file' name='files[]' id='files' multiple>
    </div>
    <div>
        <button type="submit">Upload</button>
    </div>
</form>