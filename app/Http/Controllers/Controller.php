<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Tymon\JWTAuth\Facades\JWTAuth;

class Controller extends BaseController {
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    // protected function validaPermissao($token, $siglaPermissao, $tipoPermissao) {
    //     // return $this->validaPermissao($request->bearerToken(), 'CAD_USUARIO', 'consultar');
    //     $dados = JWTAuth::getPayload($token)->toArray();
    //     $user = $dados['sub'];
    //     return $user;
    // }
}
