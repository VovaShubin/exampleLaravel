<?php

namespace App\Modules\DataAggregation\Content\UI\API\V1\Controllers;


class ContentApiController extends ApiController
{
    public function __construct(
        private readonly Test                                 $test
    )
    {

    }

    public function test(): array
    {
        $payload = $this->test->run();
        return $payload;
    }
}
