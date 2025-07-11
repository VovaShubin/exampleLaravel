<?php

namespace App\Core\Contracts\Resource;

use Illuminate\Contracts\Support\Arrayable;
use \Closure;

interface IAttribute extends Arrayable
{
    /**
     * Format attribute
     *
     * @param Closure $closure
     * @return self
     */
    public function format(Closure $closure): self;

    /**
     * @return string
     */
    public function container(): string;
}
