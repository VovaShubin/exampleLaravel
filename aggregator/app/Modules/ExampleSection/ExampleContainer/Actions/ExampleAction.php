<?php

namespace App\Modules\ExampleSection\ExampleContainer\Actions;

use App\Core\Parents\Actions\Action;
use App\Core\Parents\Requests\Request;
use App\Modules\ExampleSection\ExampleContainer\Tasks\ExampleTask;


class ExampleAction extends Action
{
    public function __construct(
        private readonly ExampleTask $task
    ) {}

    public function run(Request $request): array
    {
        return $this->task->run($request);
    }

    public function run2(Request $request): array
    {
        return $this->task->run2($request);
    }
}
