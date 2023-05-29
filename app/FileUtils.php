<?php

declare(strict_types=1);

namespace App;

use App\Exceptions\FileUploadFailedException;

class FileUtils
{
    public static function store(string $fileName, string $tmp_name): ?string
    {
        $filePath = STORAGE_PATH . '/' . $fileName;

        if (move_uploaded_file($tmp_name, $filePath) === false) {
            throw new FileUploadFailedException();
        }

        return $filePath;
    }
}
