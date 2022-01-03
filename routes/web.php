<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

/*Auth*/
Route::post('login', [App\Http\Controllers\API\AuthController::class], 'login');
Route::post('logout', [App\Http\Controllers\API\AuthController::class], 'logout');

// Vue Capture
Route::get('/{vue_capture?}', function () {
    return view('welcome');
})->where('vue_capture', '[\/\w\.-]*');
