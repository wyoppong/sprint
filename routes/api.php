<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| All API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

/* Public API Routes */ 
Route::group(['prefix' => 'frontend'], function () {
    require __DIR__ . '/api/guest.php';
});

/* Private API Routes */ 
Route::group(['prefix' => 'admin', 'middleware' => 'auth:sanctum'], function () {
    require __DIR__ . '/api/admin.php';
});

