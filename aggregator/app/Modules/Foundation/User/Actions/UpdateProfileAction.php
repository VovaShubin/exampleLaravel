<?php

namespace App\Modules\Foundation\User\Actions;

use App\Core\Parents\Actions\Action;
use App\Modules\Foundation\User\Data\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UpdateProfileAction extends Action
{
    public function run(int $id, array $payload): ?User
    {
        $user = User::query()->find($id);
        $payload['password'] = is_null($payload['password']) ? null : Hash::make($payload['password']);
        $user->update($payload);
        return $user;
    }
}
