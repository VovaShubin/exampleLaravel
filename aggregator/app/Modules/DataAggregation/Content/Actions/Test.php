<?php

namespace App\Modules\DataAggregation\Content\Actions;


class Test extends Action
{

    /**
     * @var FrontApi
     */
    protected FrontApi $frontApi;

    /**
     * @var Server
     */
    protected Server $server;

    public function __construct(
    )
    {
    }

    /** @throws Throwable */
    public function run(): array
    {
      ...
        return [];
    }
}
