<?php

namespace App\Modules\Test\Resources\Booking;


use App\Core\Parents\TestSystemsIntegrations\BasicQuery;

/**
 */
class ReserveQuery extends BasicQuery
{
    /**
     * @var string
     */

    protected string $url = "https://test";

    /**
     * @var string
     */
    protected string $method = "PUT";

    /**
     * @var array|string[]
     */
    protected array $headers = ["content-type" => "application/json"];

    /**
     * @return string[]
     */
    protected function expectPayloadKeys(): array
    {
        return ["commit", "pre_order", "order", "test"];
    }

    /**
     * @return void
     */
    protected function bindBody(): void
    {
        $data = [
            "order" => $this->payload["order"] ?? [],
            "commit" => $this->payload["commit"] ?? false,
            "pre_order" => false,
            "test" => $this->payload["test"] ?? []
        ];

        $this->body = json_encode($data);
    }
}
