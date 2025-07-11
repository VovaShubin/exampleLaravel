<?php

namespace App\Core\Parents\Resources;


use App\Core\Contracts\Resource\IResourceMapper;

abstract class ResourceMapper implements IResourceMapper
{

    /**
     * @param mixed $payload
     * @return mixed
     */
    abstract function id(mixed $payload): mixed;

    /**
     * @return string
     */
    abstract function type(): string;
}
