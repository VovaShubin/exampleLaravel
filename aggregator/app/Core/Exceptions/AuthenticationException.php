<?php

namespace App\Core\Exceptions;

class AuthenticationException extends Exception
{
    protected $detail = 'Неправильный логин или пароль';

    public function __construct(string $message = "", int $code = 401, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
