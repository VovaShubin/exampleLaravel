<?php

namespace App\Core\Middlewares;

use Closure;

class Authorize extends \Illuminate\Auth\Middleware\Authorize
{
    public function handle($request, Closure $next, $ability, ...$models)
    {

        $this->gate->authorize($ability, $this->getGateArguments($request, $models));

        return $next($request);
    }
}
