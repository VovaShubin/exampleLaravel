<?php

namespace App\Modules\ExampleSection\ExampleContainer\UI\API\Controllers;

use App\Core\Parents\Controllers\ApiController;
use App\Modules\ExampleSection\ExampleContainer\Actions\ExampleAction;
use App\Modules\ExampleSection\ExampleContainer\Actions\TestAction;
use App\Modules\ExampleSection\ExampleContainer\UI\API\Requests\ExampleRequestForApi;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ExampleControllerForApiRequests extends ApiController
{
    public function __construct(
        private readonly ExampleAction $action
    ) {}

    public function testApi(ExampleRequestForApi $request): JsonResponse
    {
        $data = $this->action->run($request);

        return new JsonResponse($data);
    }

    public function testResponse(Request $request)
    {
        logger()->channel('payments')->debug('>>> REQUEST IS: <<<');
        logger()->channel('payments')->debug(print_r($request->all(), true));

        return response(['status' => 'success']);
    }

    public function testApi2(ExampleRequestForApi $request): JsonResponse
    {   
        $data = $this->action->run2($request);
        return new JsonResponse($data);
    }
}
