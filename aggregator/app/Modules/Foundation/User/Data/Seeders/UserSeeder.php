<?php

namespace App\Modules\Foundation\User\Data\Seeders;

use App\Core\Parents\Seeders\Seeder;
use App\Modules\Foundation\User\Data\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::query()->firstOrCreate([
            'name' => 'Test user',
            'email' => 'test@mail.ru',
            'password' => Hash::make('password'),
            'phone' => '+7000000000'
        ]);


    }
}
