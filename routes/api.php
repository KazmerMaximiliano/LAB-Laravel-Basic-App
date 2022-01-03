<?php

use Illuminate\Support\Facades\Route;

/*Auth*/
Route::post('login', [App\Http\Controllers\API\ApiAuthController::class, 'apiLogin']);
Route::post('logout', [App\Http\Controllers\API\ApiAuthController::class, 'apiLogout']);

/*Social Auth*/
Route::post('auth/google', [App\Http\Controllers\API\ApiAuthController::class, 'google']);
Route::post('auth/facebook', [App\Http\Controllers\API\ApiAuthController::class, 'facebook']);

Route::middleware('auth:sanctum')->group(function () {
    /*Users*/
    Route::get('user', [App\Http\Controllers\API\UsersController::class, 'user']);
    Route::post('update_account', [App\Http\Controllers\API\UsersController::class, 'updateAccount']);
    Route::resource('users', App\Http\Controllers\API\UsersController::class, ['except' => ['create', 'edit', 'show',]]);

    /*Roles & Permissions*/
    Route::apiResource('roles', App\Http\Controllers\API\RolesController::class, ['except' => ['create', 'edit', 'show',]]);

    /*Websockets*/
    Route::get('websockets/test', [App\Http\Controllers\API\WebsocketsController::class], 'test');
});
