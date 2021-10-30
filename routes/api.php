<?php

use Illuminate\Support\Facades\Route;

/*Auth*/
Route::post('login', [App\Http\Controllers\API\AuthController::class, 'apiLogin']);
Route::post('logout', [App\Http\Controllers\API\AuthController::class, 'apiLogout']);

Route::middleware('auth:sanctum')->group(function () {
    /*Backup*/
    Route::get('backup/generate', 'App\Http\Controllers\API\DevController@downloadDB');
    Route::get('backup/all', 'App\Http\Controllers\API\DevController@getsBackups');
    Route::get('backup/get/{id}', 'App\Http\Controllers\API\DevController@downloadBackup');

    /*Users*/
    Route::get('user', 'App\Http\Controllers\API\UsersController@user');
    Route::post('update_account', 'App\Http\Controllers\API\UsersController@updateAccount');
    Route::apiResource('users', 'App\Http\Controllers\API\UsersController', ['except' => ['create', 'edit', 'show',]]);

    /*Roles & Permissions*/
    Route::apiResource('roles', 'App\Http\Controllers\API\RolesController', ['except' => ['create', 'edit', 'show',]]);
    Route::get('permissions', 'App\Http\Controllers\API\RolesController@permissionAll');
});
