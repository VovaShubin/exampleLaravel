<?php

namespace App\Core\Exceptions;

use App\Core\Exceptions\Traits\ExceptionMessageBagTrait;
use App\Core\Parents\Resources\ErrorResource;
use Throwable;

class Exception extends \Exception
{
    use ExceptionMessageBagTrait;

    public function __construct(string $message = "", int $code = 500, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function toResponse($request): \Illuminate\Http\Response|\Symfony\Component\HttpFoundation\Response
    {
        return (new ErrorResource($this, $this->detail))->toResponse($request);
    }
}
