<?php

namespace App\Core\Contracts\Policy;

use App\Core\Parents\Models\Model;
use App\Modules\Foundation\User\Data\Models\User;

interface IPolicy
{
    public function viewAny(User $user): bool;
    public function view(User $user, Model $model): bool;
    public function create(User $user): bool;
    public function edit(User $user, Model $model): bool;
    public function update(User $user, Model $model): bool;
    public function delete(User $user, Model $model): bool;
}
