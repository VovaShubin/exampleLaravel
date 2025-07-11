<?php

namespace App\Modules\Foundation\User\Actions;

use App\Core\Parents\Actions\Action;
use App\Modules\Foundation\User\Data\Models\User;
use Illuminate\Support\Facades\Auth;

class GetProfileAction extends Action
{
    public function run(): ?User
    {
        return Auth::user();
    }
}
