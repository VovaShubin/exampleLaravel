<?php

namespace App\Core\Exceptions;

use App\Core\Parents\Resources\ErrorResource;
use Illuminate\Contracts\Support\Responsable;

class NotFoundException extends \Exception implements Responsable
{
    public function __construct(string $message = "Not found", int $code = 404, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    /**
     * @inheritDoc
     */
    public function toResponse($request)
    {
        return new ErrorResource($this);
    }
}
