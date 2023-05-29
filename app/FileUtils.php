<?php

declare(strict_types=1);

namespace App;

use App\Exceptions\FileUploadFailedException;

class FileUtils
{
    public static function store(array $file): ?string
    {
        $filePath = STORAGE_PATH . '/' . $file['name'];

        if (move_uploaded_file($file['tmp_name'], $filePath) === false) {
            throw new FileUploadFailedException();
        }

        return $filePath;
    }
}
