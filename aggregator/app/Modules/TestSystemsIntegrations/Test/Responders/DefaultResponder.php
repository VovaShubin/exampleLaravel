<?php

namespace App\Modules\TestSystemsIntegrations\Test\Responders;

use App\Core\Parents\TestSystemsIntegrations\BasicQuery;
use App\Modules\TestSystemsIntegrations\Test\Responders\Responder;
use Psr\Http\Client\ClientInterface;

class DefaultResponder extends Responder
{
    protected string $wrapper;

    public function __construct(string $wrapper = "")
    {
        $this->wrapper = $wrapper;
    }

    /**
     * @inheritDoc
     */
    public function __invoke(BasicQuery $query, ClientInterface $client): mixed
    {
        $send = fn() => $client->sendRequest($query->makeRequest());
        $response = $this->try($send);
        $data = json_decode($response->getBody()->getContents(), 1);

        return $data[$this->wrapper] ?? $data;
    }
}
