<?php

namespace App\Core\Exceptions;

use App\Core\Exceptions\Traits\ExceptionMessageBagTrait;
use App\Core\Parents\Resources\ErrorResource;
use Illuminate\Contracts\Support\Responsable;

class ValidationException extends \Illuminate\Validation\ValidationException implements Responsable
{
    use ExceptionMessageBagTrait;

    protected $code = 422;

    public function toResponse($request): \Illuminate\Http\Response|\Symfony\Component\HttpFoundation\Response
    {
        return (new ErrorResource($this, $this->validator->errors()))->toResponse($request);
    }
}
