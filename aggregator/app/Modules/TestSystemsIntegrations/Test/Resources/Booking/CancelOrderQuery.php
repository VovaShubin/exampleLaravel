<?php

namespace App\Modules\Test\Resources\Booking;

use App\Core\Parents\TestSystemsIntegrations\BasicQuery;

/**

 */
class CancelOrderQuery extends BasicQuery
{
    /**
     * @var string
     */
    protected string $url = "https://test";

    /**
     * @var string
     */
    protected string $method = "DELETE";

    /**
     * @return void
     */
    protected function bindUrl(): void
    {
        $this->url .= "/{$this->payload['id']}";
    }

    /**
     * @return string[]
     */
    protected function expectPayloadKeys(): array
    {
        return ['id'];
    }
}
