<?php

use App\Http\Controllers\UsersController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/users', [UsersController::class, 'index']);
Route::put('/users/{user}', [UsersController::class, 'update']);
Route::delete('/users/{user}', [UsersController::class, 'destroy']);
