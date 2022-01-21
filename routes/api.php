<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PerfilController;
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

    Route::group(['prefix'=>'user', 'where'=>['id'=>'[0-9]+']], function() {
        Route::any('', [UserController::class, 'getAll']);
        Route::get('/', [UserController::class, 'getAll']);
        Route::get('/{id}', [UserController::class, 'getById']);
        Route::post('/', [UserController::class, 'save']);
        Route::put('/refreshpassword/{id}', [UserController::class, 'refreshPassword']);
        Route::put('/verifypassword/{id}', [UserController::class, 'verifyPassword']);
        Route::put('/{id}', [UserController::class, 'update']);
        Route::delete('/{id}', [UserController::class, 'delete']);
    });

    Route::group(['prefix'=>'perfil', 'where'=>['id'=>'[0-9]+']], function() {
        Route::any('', [PerfilController::class, 'getAll']);
        Route::get('/', [PerfilController::class, 'getAll']);
        Route::get('/{id}', [PerfilController::class, 'getById']);
        Route::post('/', [PerfilController::class, 'save']);
        Route::put('/{id}', [PerfilController::class, 'update']);
        Route::delete('/{id}', [PerfilController::class, 'delete']);
    });
});
