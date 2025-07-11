<?php

namespace App\Modules\Test\Resources\Front;

use App\Core\Parents\TestSystemsIntegrations\BasicQuery;

/**

 */
class OffersQuery extends BasicQuery
{
    /**
     * @var string
     */
    protected string $url = "https://test/v1/offers";

    /**
     * @var string
     */
    protected string $method = "GET";

    /**
     * @return void
     */
    protected function bindUrl(): void
    {
        $this->url .= "/{$this->payload['objectid']}";
    }

    /**
     * @return string[]
     */
    protected function expectPayloadKeys(): array
    {
        return ['objectid'];
    }

    /**
     * @return string[]
     */
    protected function bindingParams(): array
    {
        return ["test1", "test2", "duration", "from", "to"];
    }
}
