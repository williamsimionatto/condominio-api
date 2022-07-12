<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CashFlowController;
use App\Http\Controllers\CommonAreaController;
use App\Http\Controllers\CondominioController;
use App\Http\Controllers\CondominoController;
use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\LeituraAguaController;
use App\Http\Controllers\LeituraAguaReportController;
use App\Http\Controllers\LeituraAguaValoresController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\PerfilPermissaoController;
use App\Http\Controllers\PeriodController;
use App\Http\Controllers\PermissaoController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\UserController;

use Illuminate\Support\Facades\Route;

Route::post('auth/login', [AuthController::class, 'login']);

Route::group(['middleware'=>['apiJWT', 'cors']], function() {
    Route::group(['prefix'=>'cashflow'], function () {
        Route::get('', [CashFlowController::class, 'getAll']);
        Route::post('', [CashFlowController::class, 'save']);
    });

    Route::group(['prefix'=>'commonarea'], function() {
        Route::get('', [CommonAreaController::class, 'getAll']);
        Route::get('{id}', [CommonAreaController::class, 'getById']);
        Route::post('', [CommonAreaController::class, 'save']);
        Route::put('{id}', [CommonAreaController::class, 'update']);
        Route::delete('{id}', [CommonAreaController::class, 'delete']);
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

    Route::group(['prefix'=>'period', 'where'=>['id'=>'[0-9]+']], function() {
        Route::get('', [PeriodController::class, 'getAll']);
        Route::get('{id}', [PeriodController::class, 'getById']);
        Route::post('', [PeriodController::class, 'save']);
        Route::put('{id}', [PeriodController::class, 'update']);
        Route::delete('{id}', [PeriodController::class, 'delete']);
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

    Route::group(['prefix'=>'reservation', 'where'=>['id'=>'[0-9]+']], function() {
        Route::get('', [ReservationController::class, 'getAll']);
        Route::get('/{id}', [ReservationController::class, 'getById']);
        Route::post('', [ReservationController::class, 'save']);
        Route::put('/{id}', [ReservationController::class, 'update']);
        Route::delete('/{id}', [ReservationController::class, 'delete']);
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
