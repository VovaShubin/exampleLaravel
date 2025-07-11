<?php

namespace App\Core\Contracts\TestSystemsIntegrations;

use Carbon\Carbon;
use Psr\Http\Client\ClientExceptionInterface;

interface ServerCommunication
{
    public function orders(array $payload): array;
}
