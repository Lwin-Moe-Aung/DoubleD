<?php

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/getting-stock', [App\Http\Controllers\API\StockController::class, 'gettingStock']);
Route::get('/getting-tips', [App\Http\Controllers\API\TipsController::class, 'gettingTips']);
Route::get('/getting-history/{day}', [App\Http\Controllers\API\StockController::class, 'getHistory']);