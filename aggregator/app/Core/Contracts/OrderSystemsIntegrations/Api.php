<?php

namespace App\Core\Contracts\TestSystemsIntegrations;

use Psr\Http\Message\ResponseInterface;

interface Api
{

    /**
     * Dispatch api query
     *
     * @param ...$args
     * @return mixed|ResponseInterface
     */
    public function dispatch(...$args): mixed;
}
