<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/account', [\App\Http\Controllers\Api\AccountController::class, 'index']);
Route::post('/account', [\App\Http\Controllers\Api\AccountController::class, 'store']);

Route::get('/deal', [\App\Http\Controllers\Api\DealController::class, 'index']);
Route::get('/deals/get-by-account-id/{accountID}', [\App\Http\Controllers\Api\DealController::class, 'getDealsByAccountId']);
Route::post('/deal', [\App\Http\Controllers\Api\DealController::class, 'store']);
Route::get('/deal/{id}', [\App\Http\Controllers\Api\DealController::class, 'show']);
Route::patch('/deal/{id}', [\App\Http\Controllers\Api\DealController::class, 'update']);
