<?php

namespace App\Core\Helpers;

use App\Core\Exceptions\AuthorizationException;
use Illuminate\Support\Facades\Gate;
use Throwable;

class AuthorizationHelper
{
    /**@throws Throwable */
    public static function authorize(string $ability, ...$params): void
    {
        $result = Gate::raw($ability, $params);
        throw_if($result instanceof Throwable);
    }
}
