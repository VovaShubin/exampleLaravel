<?php

namespace App\Modules\Test\Responders;

use App\Core\Contracts\TestSystemsIntegrations\Responder as ResponderContract;
use Closure;
use Illuminate\Support\Facades\Log;
use Psr\Http\Message\ResponseInterface;

abstract class Responder implements ResponderContract
{
    /**
     * @param Closure $send
     * @return ResponseInterface
     */
    protected function try(Closure $send): ResponseInterface
    {
        try {
            $tryNumber = 0;
            do {
                if (++$tryNumber > 1) {
                    $sleep = $this->fib($tryNumber);
                    if (!app()->isProduction()) {
                        Log::info('Got status 429 from Test. Sleep before retry: ' . $sleep . 's');
                    }
                    sleep($sleep);
                }

                /** @var ResponseInterface $response */
                $response = $send();

            } while ($response->getStatusCode() == 429);
            return $response;
        } catch (\Throwable $exception) {
            return new \GuzzleHttp\Psr7\Response(500, [], json_encode(['error' => ['Невозможно выполнить запрос']]));
        }
    }

    private function fib($n): int
    {
        return (int)round(pow((sqrt(5) + 1) / 2, $n) / sqrt(5));
    }
}
