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
 
Route::group(['middleware'=>'apiJWT'], function() {
    Route::group(['prefix'=>'auth'], function() {
        Route::get('me', [AuthController::class, 'me']); 
        Route::get('logout', [AuthController::class, 'logout']); 
        Route::get('refresh', [AuthController::class, 'refresh']); 
    });

    Route::group(['prefix'=>'users', 'where'=>['id'=>'[0-9]+']], function() {
        Route::any('', [UserController::class, 'index']);
        Route::get('/users', [UserController::class, 'index']); 
    });
});
