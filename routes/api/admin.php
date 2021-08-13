<?php
/*
|--------------------------------------------------------------------------
| Admin API Routes
|--------------------------------------------------------------------------
| Here is where all backend API routes for the application is registered.
*/

use App\Http\Controllers\Users;

/* Users */ 
Route::group(['prefix' => 'users'], function () {
    Route::get('/', [Users::class, 'index']);
});

