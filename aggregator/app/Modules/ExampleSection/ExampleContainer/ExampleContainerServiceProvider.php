<?php

namespace App\Modules\ExampleSection\ExampleContainer;

use App\Core\Parents\Providers\ServiceProvider;

class ExampleContainerServiceProvider extends ServiceProvider
{

    /**
     * @return void
     */
    public function boot(): void
    {
        parent::boot();

        $this->loadAPIRoutes('');
        $this->loadWEBRoutes();
        $this->loadCommands();
    }
}
