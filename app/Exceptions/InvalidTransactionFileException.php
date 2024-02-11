<?php

namespace App\Exceptions;

use Exception;

class InvalidTransactionFileException extends Exception
{

    protected $message = 'Transaction have not sent or is in invalid format';
}