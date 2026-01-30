<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class UnauthorizedTaskActionException extends Exception
{
    private const DEFAULT_MESSAGE = 'You are not authorized to perform this task action.';

    public function __construct($message = self::DEFAULT_MESSAGE, $code = null, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
