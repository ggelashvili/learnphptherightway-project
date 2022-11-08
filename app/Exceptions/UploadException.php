<?php

declare(strict_types = 1);

namespace App\Exceptions;

class UploadException extends \Exception
{
    protected $message = 'The action failed';
}
