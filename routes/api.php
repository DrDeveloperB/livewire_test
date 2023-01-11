<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

/**
 * auth:sanctum
 * auth:api
 */
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/registers', [AuthController::class, 'register'])->name('registers');
Route::post('/logins', [AuthController::class, 'login'])->name('logins');

Route::group(['middleware' => ['auth:api']], function() {
    Route::post('/logouts', [AuthController::class, 'logout'])->name('logouts');
});
