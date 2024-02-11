<?php

namespace App\Exceptions;

use Exception;

class InvalidPropertyAccessException extends Exception
{
    protected $message = 'Property does not exist';
}