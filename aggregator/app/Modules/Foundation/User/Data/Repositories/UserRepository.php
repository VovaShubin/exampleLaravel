<?php

namespace App\Modules\Foundation\User\Data\Repositories;


use App\Core\Parents\Repositories\Repository;
use App\Modules\Foundation\User\Data\Models\User;

class UserRepository extends Repository
{
    public function model(): string
    {
        return User::class;
    }

    public function getUserByUsername(string $username): ?User
    {
        /** @var User|null $user */
        $user = User::query()
            ->where('phone', $username)
            ->orWhere('phone', preg_replace(["/^\+7/", "/^7/"], "8", $username))
            ->orWhere('email', $username)
            ->first();
        return $user;
    }
}
