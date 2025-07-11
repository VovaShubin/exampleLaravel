<?php

namespace App\Core\Parents\Resources\Resolvers\Payload;

use App\Core\Contracts\Resource\IResourcePayload;
use App\Core\Contracts\Resource\IResourcePayloadResolver;
use App\Core\Parents\Resources\ResourcePayload;
use Illuminate\Contracts\Support\Arrayable;

class ArraybleResourcePayloadResolver implements IResourcePayloadResolver
{
    /**
     * @inheritDoc
     */
    public function resolve($payload): ?IResourcePayload
    {
        if (is_array($payload)) {
            $result = new ResourcePayload($payload);
        }

        if($payload instanceof Arrayable){
            $result = new ResourcePayload($payload->toArray());
        }

        return $result ?? null;
    }
}
