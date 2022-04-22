<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CondominioController;
use App\Http\Controllers\CondominoController;
use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\LeituraAguaController;
use App\Http\Controllers\LeituraAguaReportController;
use App\Http\Controllers\LeituraAguaValoresController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\PerfilPermissaoController;
use App\Http\Controllers\PermissaoController;
use App\Http\Controllers\UserController;
use App\Models\PerfilPermissao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('auth/login', [AuthController::class, 'login']);

Route::group(['middleware'=>'apiJWT'], function() {
    Route::group(['prefix'=>'auth'], function() {
        Route::get('me', [AuthController::class, 'me']);
        Route::get('logout', [AuthController::class, 'logout']);
        Route::get('refresh', [AuthController::class, 'refresh']);
    });

    Route::group(['prefix'=>'condominio', 'where'=>['id'=>'[0-9]+']], function() {
        Route::get('', [CondominioController::class, 'getAll']);
        Route::get('{id}', [CondominioController::class, 'getById']);
        Route::post('', [CondominioController::class, 'save']);
        Route::put('{id}', [CondominioController::class, 'update']);
        Route::delete('{id}', [CondominioController::class, 'delete']);
    });

    Route::group(['prefix'=>'condomino', 'where'=>['id'=>'[0-9]+']], function() {
        Route::get('', [CondominoController::class, 'getAll']);
        Route::get('{id}', [CondominoController::class, 'getByCondomino']);
        Route::post('', [CondominoController::class, 'save']);
        Route::put('{id}', [CondominoController::class, 'update']);
    });

    Route::group(['prefix'=>'leituraagua', 'where'=>['id'=>'[0-9]+']], function() {
        Route::get('', [LeituraAguaController::class, 'getAll']);
        Route::get('{id}', [LeituraAguaController::class, 'getById']);
        Route::get('/isUniqueLeituraMonth', [LeituraAguaController::class, 'isUniqueLeituraMonth']);
        Route::get('{id}/condominio', [LeituraAguaController::class, 'getByCondominio']);
        Route::post('', [LeituraAguaController::class, 'save']);
        Route::put('{id}', [LeituraAguaController::class, 'update']);
        Route::delete('{id}', [LeituraAguaController::class, 'delete']);
        Route::get('condominos', [LeituraAguaValoresController::class, 'getCondominos']);
        Route::get('condominos/valores', [LeituraAguaValoresController::class, 'getValoresCondominos']);
        Route::post('condominos/valores', [LeituraAguaValoresController::class, 'save']);
        Route::put('condominos/valores/{id}', [LeituraAguaValoresController::class, 'update']);
        Route::post('condominos/{id}/boleto', [FileUploadController::class, 'save']);
        Route::get('condominos/{id}/boleto', [FileUploadController::class, 'downloadFile']);
        Route::delete('condominos/{id}/boleto', [FileUploadController::class, 'deleteFile']);
    });

    Route::group(['prefix'=>'perfil', 'where'=>['id'=>'[0-9]+']], function() {
        Route::any('', [PerfilController::class, 'getAll']);
        Route::get('/', [PerfilController::class, 'getAll']);
        Route::get('/{id}', [PerfilController::class, 'getById']);
        Route::post('/', [PerfilController::class, 'save']);
        Route::put('/{id}', [PerfilController::class, 'update']);
        Route::delete('/{id}', [PerfilController::class, 'delete']);
    });

    Route::group(['prefix'=>'permissao', 'where'=>['id'=>'[0-9]+']], function() {
        Route::any('', [PermissaoController::class, 'getAll']);
        Route::get('/', [PermissaoController::class, 'getAll']);
        Route::get('/{id}', [PermissaoController::class, 'getById']);
        Route::post('/', [PermissaoController::class, 'save']);
    });

    Route::group(['prefix'=>'perfilpermissao', 'where'=>['id'=>'[0-9]+']], function() {
        Route::get('/{id}', [PerfilPermissaoController::class, 'getPermissoesByPerfil']);
        Route::post('/', [PerfilPermissaoController::class, 'save']);
    });

    Route::group(['prefix'=>'report'], function() {
        Route::get('leituraagua', [LeituraAguaReportController::class, 'report']);
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
});
