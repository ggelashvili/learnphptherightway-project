<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;

class MimeTypeNotAllowedException extends Exception
{
    protected $message = 'Invalid file type.';
}
