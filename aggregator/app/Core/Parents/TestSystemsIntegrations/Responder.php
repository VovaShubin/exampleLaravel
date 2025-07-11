<?php

namespace App\Core\Parents\TestSystemsIntegrations;

use Psr\Http\Client\ClientInterface;

abstract class Responder
{
    /**
     * @param ClientInterface $client
     * @param BasicQuery $query
     * @return mixed
     */
    abstract public function __invoke(ClientInterface $client, BasicQuery $query): mixed;
}
