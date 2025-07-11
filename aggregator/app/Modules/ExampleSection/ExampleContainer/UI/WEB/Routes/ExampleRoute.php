<?php


use App\Modules\ExampleSection\ExampleContainer\UI\WEB\Controllers\ExampleControllerForWebRequests;
use Illuminate\Support\Facades\Route;

Route::get('test-web', ExampleControllerForWebRequests::class);
