<?php

namespace App\Core\Parents\Resources\Mappers;

use App\Core\Parents\Resources\Attributes\JsonApi;
use App\Core\Parents\Resources\ResourceMapper;

abstract class ResourceMapper_V1 extends ResourceMapper
{

    /**
     * @inheritDoc
     */
    public function errors($payload, $request = null): array
    {
        return [];
    }


    /**
     * @inheritDoc
     */
    public function jsonapi($payload, $request = null): array
    {
        return [
            JsonApi::make("version", '1.1')
        ];
    }

    /**
     * @inheritDoc
     */
    function id(mixed $payload): mixed
    {
        return $payload["id"] ?? null;
    }
}
