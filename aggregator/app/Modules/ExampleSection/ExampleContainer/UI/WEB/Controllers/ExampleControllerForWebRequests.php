<?php

namespace App\Modules\ExampleSection\ExampleContainer\UI\WEB\Controllers;

use App\Core\Parents\Controllers\ApiController;
use App\Modules\ExampleSection\ExampleContainer\Actions\ExampleAction;
use App\Modules\ExampleSection\ExampleContainer\UI\WEB\Requests\ExampleRequestForWeb;

class ExampleControllerForWebRequests extends ApiController
{
    public function __construct(
        private readonly ExampleAction $action
    ) {}

    public function __invoke(ExampleRequestForWeb $request): \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $data = print_r($this->action->run($request), true);

        return view('example-view', compact('data'));
    }
}
