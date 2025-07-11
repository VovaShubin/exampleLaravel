<?php

namespace App\Modules\Foundation\User;

use App\Core\Parents\Providers\ServiceProvider;

class UserServiceProvider extends ServiceProvider
{

    /**
     * @return void
     */
    public function boot(): void
    {
        parent::boot();

        $this->loadAPIRoutes('V1');

        $this->loadCommands();
    }
}
