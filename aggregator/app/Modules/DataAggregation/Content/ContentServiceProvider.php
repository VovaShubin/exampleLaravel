<?php

namespace App\Modules\DataAggregation\Content;

use App\Core\Parents\Providers\ServiceProvider;

class ContentServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        parent::boot();

        $this->loadAPIRoutes("V1");
    }
}
