<?php

namespace App\Modules\TestSystemsIntegrations\Test\Exceptions;

use App\Core\Exceptions\Exception;
use App\Core\Exceptions\Traits\ExceptionMessageBagTrait;
use Throwable;

class SendPaymentException extends Exception
{
    use ExceptionMessageBagTrait;

    public function __construct(string $message = "Не удалось передать платеж системе ", int $code = 423, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
