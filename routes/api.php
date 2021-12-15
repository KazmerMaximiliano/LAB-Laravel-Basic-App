<?php

use Illuminate\Support\Facades\Route;

/*Auth*/
Route::post('login', [App\Http\Controllers\API\AuthController::class, 'apiLogin']);
Route::post('logout', [App\Http\Controllers\API\AuthController::class, 'apiLogout']);

/*Social Auth*/
Route::post('auth/google', [App\Http\Controllers\API\AuthController::class, 'google']);
Route::post('auth/facebook', [App\Http\Controllers\API\AuthController::class, 'facebook']);

Route::middleware('auth:sanctum')->group(function () {
    /*Users*/
    Route::get('user', 'App\Http\Controllers\API\UsersController@user');
    Route::post('update_account', 'App\Http\Controllers\API\UsersController@updateAccount');
    Route::apiResource('users', 'App\Http\Controllers\API\UsersController', ['except' => ['create', 'edit', 'show',]]);

    /*Roles & Permissions*/
    Route::apiResource('roles', 'App\Http\Controllers\API\RolesController', ['except' => ['create', 'edit', 'show',]]);
    Route::get('permissions', 'App\Http\Controllers\API\RolesController@permissionAll');
});
