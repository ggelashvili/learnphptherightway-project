<?php

declare(strict_types=1);

namespace App;

use App\Exceptions\CanNotOpenCsvFileException;
use DateTime;

class CsvReader
{
    private $fileHandle;
    private array $headers;

    public function __construct(private string $filePath)
    {
        $this->fileHandle = fopen($this->filePath, 'r');

        if ($this->fileHandle === false)
            throw new CanNotOpenCsvFileException();

        $this->headers = fgetcsv($this->fileHandle);
    }

    public function parseTransactionRow(): array|false
    {
        $row = fgetcsv($this->fileHandle);

        if ($row !== false) {
            $row[0] = DateTime::createFromFormat('m/d/Y', $row[0]);
            $row[1] = $row[1] ? (int) $row[1] : null;
            $row[3] = (float) str_replace(['$', ','], '', $row[3]);
        }

        return $row;
    }
}
