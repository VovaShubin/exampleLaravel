<?php

namespace App\Core\Exceptions;

use Throwable;

class AuthorizationException extends Exception
{
    protected $detail = 'Authorization failed';

    public function __construct(string $message = "Authorization failed", int $code = 401, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
