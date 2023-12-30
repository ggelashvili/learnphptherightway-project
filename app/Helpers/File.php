<?php

namespace App\Helpers;

use Exception;

class File
{

    public function __construct(protected string $path)
    {
    }
    public function csv(): array
    {

        try {
            if (file_exists($this->path)) {
                $file = fopen($this->path, 'r');
                $headers = fgetcsv($file);
                while (($row = fgetcsv($file)) !== false) {
                    $content[] = $row;
                }
                fclose($file);
                return [$headers, $content];
            } else throw new Exception('File does not exist');
        } catch (\Throwable $e) {
            echo $e->getMessage();
            return [];
        }
    }
}
