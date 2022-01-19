<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
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

Route::post('auth/login', [AuthController::class, 'login']);
 
Route::middleware(['apiJWT'])->group(function () {
    Route::get('auth/me', [AuthController::class, 'me']); 
    Route::get('auth/logout', [AuthController::class, 'logout']); 
    Route::get('auth/refresh', [AuthController::class, 'refresh']); 
    Route::get('/users', [UserController::class, 'index']); 
});
