<?php

namespace App\Core\Parents\TestSystemsIntegrations;

use App\Core\Contracts\TestSystemsIntegrations\Query;
use App\Modules\TestSystemsIntegrations\Test\Resources\Front\TestObjectListQuery;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\RequestInterface;

abstract class BasicQuery implements Query
{
    /**
     * @var string
     */
    protected string $method = "GET";

    /**
     * @var string
     */
    protected string $url = "";

    /**
     * @var array
     */
    protected array $headers = [];

    /**
     * @var mixed
     */
    protected mixed $body = null;

    /**
     * @var array
     */
    protected array $payload = [];

    /**
     * @var string
     */
    protected string $version = '1.1';

    /**
     * @param array $payload
     */
    public function __construct(array $payload = [])
    {
        $this->payload = $payload;

        $this->boot();
    }

    /**
     * @return string
     */
    public function url(): string
    {
        return $this->url;
    }

    /**
     * @return RequestInterface
     */
    public function makeRequest(): RequestInterface
    {
        return new Request($this->method, $this->url, $this->headers, $this->body, $this->version);
    }

    /**
     * @return void
     */
    protected function boot(): void
    {
        $this->checkExpectedOptions();

        $this->bindUrl();

        $this->bindParamsToUrl();

        $this->bindBody();
    }

    /**
     * @return void
     */
    protected function bindParamsToUrl(): void
    {
        $params = array_intersect_key($this->payload, array_flip($this->bindingParams()));

        if (!empty($params)) {

            $this->url = $this->url . "?" . http_build_query($params);

        }
    }

    /**
     * @return void
     */
    protected function bindUrl(): void
    {

    }

    /**
     * @return void
     */
    protected function bindBody(): void
    {

    }

    /**
     * @return void
     */
    protected function checkExpectedOptions(): void
    {
        foreach ($this->expectPayloadKeys() as $expectedOptionKey) {

            if (!isset($this->payload[$expectedOptionKey])) {

                throw new  \UnexpectedValueException("$expectedOptionKey not found in payload");
            }

        }
    }

    /**
     * @return array
     */
    protected function bindingParams(): array
    {
        return [];
    }


    /**
     * @return array
     */
    protected function expectPayloadKeys(): array
    {
        return [];
    }

}
