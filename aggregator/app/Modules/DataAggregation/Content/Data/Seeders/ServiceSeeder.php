<?php

namespace App\Modules\DataAggregation\Content\Data\Seeders;

use App\Core\Parents\Seeders\Seeder;
use App\Modules\DataAggregation\Content\Data\Models\Service;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        Service::firstOrCreate(["name" => "Сервис", "description" => "Описание сервиса"]);
    }
}
