<?php

/**
 * View for the file(s) upload page.
 */
?>

<form action="/upload" method="POST" enctype="multipart/form-data">
    <label for="files">Upload files:</label>
    <input type="file" id="files" name="files[]" multiple>
    <button type="submit" name="Upload">Upload</button>
</form>
