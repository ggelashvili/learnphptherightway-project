<?php

declare(strict_types=1);

namespace App\Exceptions;

class CanNotOpenCsvFileException extends \Exception
{
    protected $message = 'fopen returned false when trying to open the csv file.';
}
