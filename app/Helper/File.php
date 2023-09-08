<?php

declare(strict_types=1);

namespace App\Helper;

class File
{
    public static function upload(string $name, string $tmpName): bool
    {
        move_uploaded_file($tmpName, STORAGE_PATH . "/" . "{$name}");

        return true;
    }

    public static function getFileInfo(array $files): array
    {
        $fileInfo = [];

        foreach ($files['name'] as $key => $filename) {
            $fileInfo[] = ['name' => $filename, 'tmp_name' => $files['tmp_name'][$key]];
        }

        return $fileInfo;
    }
}
