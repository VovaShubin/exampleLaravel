<?php

namespace App\Core\Parents\Policies;

use App\Core\Contracts\Policy\IPolicy;
use App\Core\Parents\Models\Model;
use App\Modules\Foundation\User\Data\Models\User;

abstract class Policy
{
    public function viewAny(User $user)
    {
        return true;
    }


    public function view(User $user, Model $model)
    {
        return true;
    }


    public function create(User $user)
    {
        return true;
    }

    public function edit(User $user, Model $model)
    {
        return true;
    }

    public function update(User $user, Model $model)
    {
        return true;
    }

    public function delete(User $user, Model $model)
    {
        return true;
    }
}
