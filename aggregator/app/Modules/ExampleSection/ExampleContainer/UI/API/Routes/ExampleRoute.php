<?php


use App\Modules\ExampleSection\ExampleContainer\UI\API\Controllers\ExampleControllerForApiRequests;
use Illuminate\Support\Facades\Route;

Route::get('test-api2', [ExampleControllerForApiRequests::class, 'testApi2']);
Route::get('test-api', [ExampleControllerForApiRequests::class, 'testApi']);
Route::post('test-response', [ExampleControllerForApiRequests::class, 'testResponse']);
