<?php

declare(strict_types=1);

namespace App\Exceptions;

class FileUploadFailedException extends \Exception
{
    protected $message = 'move_uploaded_file returned false when trying to move file into storage path';
}
