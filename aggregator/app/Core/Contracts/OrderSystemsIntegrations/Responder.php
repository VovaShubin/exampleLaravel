<?php

namespace App\Core\Contracts\TestSystemsIntegrations;

use App\Core\Parents\TestSystemsIntegrations\BasicQuery;
use Psr\Http\Client\ClientInterface;

interface Responder
{

    /**
     * @param BasicQuery $query
     * @param ClientInterface $client
     * @return mixed
     */
    public function __invoke(BasicQuery $query, ClientInterface $client): mixed;
}
