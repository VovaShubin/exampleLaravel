<?php

namespace App\Core\Contracts\TestSystemsIntegrations;

use Psr\Http\Message\RequestInterface;

interface Query
{
    /**
     * @return RequestInterface
     */
    public function makeRequest(): RequestInterface;
}
