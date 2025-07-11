<?php

namespace App\Modules\Foundation\User\UI\API\V1\Controllers;

use App\Core\Parents\Controllers\ApiController;
use App\Core\Parents\Resources\Resource;
use App\Modules\Foundation\User\Actions\GetProfileAction;
use App\Modules\Foundation\User\Actions\UpdateProfileAction;
use App\Modules\Foundation\User\UI\API\V1\Requests\UpdateProfileRequest;
use App\Modules\Foundation\User\UI\API\V1\Resources\UserResource;
use App\Modules\Foundation\User\UI\API\V1\Resources\UserResourceMapper;
use Illuminate\Support\Facades\Auth;

class UserApiController extends ApiController
{
    public function profile(): Resource
    {
        $action = app(GetProfileAction::class);
        $result = $action->run() ?? [];
        return UserResource::make($result, UserResourceMapper::class);
    }

    public function updateProfile(UpdateProfileRequest $request): Resource
    {
        $action = app(UpdateProfileAction::class);
        $result = $action->run(Auth::user()->id, $request->validated()) ?? [];
        return UserResource::make($result, UserResourceMapper::class);
    }
}
