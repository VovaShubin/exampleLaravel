<?php

namespace App\Modules\Foundation\User\UI\API\V1\Requests;

use App\Core\Parents\Requests\Request;

class UpdateProfileRequest extends Request
{

    /**
     * @inheritDoc
     */
    public function rules(): array
    {
        return [
            'first_name' => ['string'],
            'middle_name' => ['string'],
            'last_name' => ['string'],
            'birthdate' => ['date'],
            'phone' => ['string', 'unique:users,phone'],
            'password' => ['confirmed']
        ];
    }
}
