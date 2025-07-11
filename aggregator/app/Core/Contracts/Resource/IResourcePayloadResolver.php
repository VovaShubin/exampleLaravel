<?php

namespace App\Core\Contracts\Resource;

interface IResourcePayloadResolver
{

    /**
     * @param $payload
     * @return IResourcePayload|null
     */
    public function resolve($payload): ?IResourcePayload;
}
