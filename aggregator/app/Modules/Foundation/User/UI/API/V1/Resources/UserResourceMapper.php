<?php

namespace App\Modules\Foundation\User\UI\API\V1\Resources;

use App\Core\Parents\Resources\Attributes\Attribute;
use App\Core\Parents\Resources\Mappers\ResourceMapper_V1;
use Illuminate\Support\Carbon;

class UserResourceMapper extends ResourceMapper_V1
{

    /**
     * @inheritDoc
     */
    public function data($payload, $request = null): array
    {
        return [
            Attribute::make('first_name', $payload['first_name'] ?? null),
            Attribute::make('middle_name', $payload['middle_name'] ?? null),
            Attribute::make('last_name', $payload['last_name'] ?? null),
            Attribute::make('phone', $payload['phone'] ?? null),
            Attribute::make('email', $payload['email'] ?? null),
            Attribute::make('birthdate', $payload['birthdate'] ?? null)
                ->format(fn($value) => is_null($value)
                    ? $value
                    : Carbon::parse($value)->format('d.m.Y')
                )
        ];
    }

    /**
     * @inheritDoc
     */
    public function meta($payload, $request = null): array
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    public function links($payload, $request = null): array
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    function type(): string
    {
        return "users";
    }
}
