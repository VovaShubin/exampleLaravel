<?php

namespace App\Core\Parents\TestSystemsIntegrations;

use App\Core\Contracts\TestSystemsIntegrations\Api;
use App\Core\Contracts\TestSystemsIntegrations\Responder;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\ResponseInterface;

abstract class BasicApi implements Api
{

    /**
     * @var ClientInterface
     */
    protected ClientInterface $client;

    /**
     * @param ClientInterface $client
     */
    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**@throws ClientExceptionInterface */
    public function dispatch(...$args): mixed
    {
        return $this->respond(...$args);
    }

    /**
     * @param BasicQuery $query
     * @param Responder|null $responder
     * @return mixed|ResponseInterface
     * @throws ClientExceptionInterface
     */
    protected function respond(BasicQuery $query, ?Responder $responder = null): mixed
    {
        return is_null($responder) ? $this->defaultResponder($query) : $responder(query: $query, client: $this->client);
    }

    /**
     * @param BasicQuery $query
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     */
    protected function defaultResponder(BasicQuery $query): ResponseInterface
    {
        return $this->client->sendRequest($query->makeRequest());
    }
}
