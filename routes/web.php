<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [\App\Http\Controllers\AccountsController::class, 'index'])
    ->name('accounts.index')
    ->middleware('auth');
Route::get('/deals', [\App\Http\Controllers\DealsController::class, 'index'])
    ->name('deals.index')
    ->middleware('auth');

Auth::routes();
