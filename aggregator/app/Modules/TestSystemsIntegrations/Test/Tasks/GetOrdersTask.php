<?php

namespace App\Modules\Test\Tasks;

use Psr\Http\Client\ClientExceptionInterface;

class GetOrdersTask extends TestTask
{
    /**@throws ClientExceptionInterface */
    public function run(DocApi $docApi, array $payload): array
    {
        return $docApi->orders($payload) ?? [];
    }
}
