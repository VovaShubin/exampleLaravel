<?php

namespace App\Modules\DataAggregation\Content\Data\Models;

use App\Core\Parents\Models\Casts\OctoberGalleryJson;
use App\Core\Parents\Models\Model;

class Test extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'title',
        'svg',
        'content'
    ];
}
