<?php

declare(strict_types=1);

namespace App;

class File
{
    public static function normalize(string $key): array
    {
        $files = [];

        if (isset($_FILES[$key])) {
            for ($i = 0; $i < count($_FILES[$key]['tmp_name']); $i++) {
                $files[] = [
                    'path' => $_FILES[$key]['tmp_name'][$i],
                    'type' => $_FILES[$key]['type'][$i],
                    'error' => $_FILES[$key]['error'][$i],
                ];
            }
        }

        return $files;
    }

    public static function isCSV(string $filePath)
    {
        $csvMimeTypeExtension = [
            'application/csv',
            'text/csv',
            'text/plain',
            'application/vnd.ms-excel',
            'text/x-csv',
        ];

        $fileInfo = finfo_open(FILEINFO_MIME_TYPE);
        $fileType = finfo_file($fileInfo, $filePath);

        return in_array($fileType, $csvMimeTypeExtension);
    }
}
