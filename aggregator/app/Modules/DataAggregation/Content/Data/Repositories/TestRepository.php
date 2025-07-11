<?php

namespace App\Modules\DataAggregation\Content\Data\Repositories;

use App\Core\Parents\Repositories\Repository;
use App\Modules\DataAggregation\Content\Data\Models\Test;

class TestRepository extends Repository
{
    public function model(): string
    {
        return Test::class;
    }
}
