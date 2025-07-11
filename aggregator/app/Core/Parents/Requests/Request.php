<?php

namespace App\Core\Parents\Requests;

use App\Core\Exceptions\ValidationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest as LaravelFormRequest;

abstract class Request extends LaravelFormRequest
{
    /**
     * @return array
     */
    abstract public function rules(): array;

    /**
     * @param \Illuminate\Validation\Validator $validator
     * @return void
     */
    public function withValidator(\Illuminate\Validation\Validator $validator): void
    {
        $validator->addRules(["included" => ["array"]]);
    }

    /**
     * @param Validator $validator
     * @return void
     * @throws ValidationException
     */
    protected function failedValidation(Validator $validator): void
    {
        throw (new ValidationException($validator, null))
            ->errorBag($this->errorBag)
            ->redirectTo($this->getRedirectUrl());
    }
}
