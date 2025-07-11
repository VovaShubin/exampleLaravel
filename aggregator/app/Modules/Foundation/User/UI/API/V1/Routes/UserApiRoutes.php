<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Foundation\User\UI\API\V1\Controllers\UserApiController;

Route::group(['middleware' => 'auth:api'], function () {
    Route::get('/v1/users/profile', [UserApiController::class, 'profile'])
        ->name('api.v1.profile');
    Route::post('/v1/users/profile', [UserApiController::class, 'updateProfile'])
        ->name('api.v1.profile.update');
});
