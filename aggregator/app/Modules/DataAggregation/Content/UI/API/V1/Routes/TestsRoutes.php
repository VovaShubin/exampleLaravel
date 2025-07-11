<?php

use App\Modules\DataAggregation\Content\UI\API\V1\Controllers\ContentApiController;
use Illuminate\Support\Facades\Route;

Route::prefix("v1")->group(function () {
    Route::get('test', [ContentApiController::class, 'test']);
});

