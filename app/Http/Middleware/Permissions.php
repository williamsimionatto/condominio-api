<?php
namespace App\Http\Middleware;

use Closure;

class Permissions {
  private $permissions = [
    'api/perfil' => [
      'slug' => 'CAD_PERFIL',
    ],
    'api/perfil/*' => [
      'slug' => 'CAD_PERFIL',
    ],
    'api/permissao/*' => [
      'slug' => 'CAD_PERMISSAO',
    ],
    'api/permissao' => [
      'slug' => 'CAD_PERMISSAO',
    ],
    'api/user/*' => [
      'slug' => 'CAD_USUARIO',
    ],
    'api/user' => [
      'slug' => 'CAD_USUARIO',
    ],
    'api/condominio/*' => [
      'slug' => 'CAD_CONDOMINIO',
    ],
    'api/condominio' => [
      'slug' => 'CAD_CONDOMINIO',
    ],
    'api/condomino/*' => [
      'slug' => 'CAD_CONDOMINO',
    ],
    'api/condomino' => [
      'slug' => 'CAD_CONDOMINO',
    ],
    'api/period/*' => [
      'slug' => 'CAD_PERIODO',
    ],
    'api/period' => [
      'slug' => 'CAD_PERIODO',
    ],
    'api/perfilpermissao/*' => [
      'slug' => 'CAD_PERFILPERMISSAO',
    ],
    'api/perfilpermissao' => [
      'slug' => 'CAD_PERFILPERMISSAO',
    ],
    'api/report/leituraagua/*' => [
      'slug' => 'REL_LEITURAAGUA',
    ],
    'api/leituraagua/*' => [
      'slug' => 'TAR_LEITURAAGUA',
    ],
    'api/leituraagua' => [
      'slug' => 'TAR_LEITURAAGUA',
    ],
    'api/cashflow/*' => [
      'slug' => 'TAR_CASHFLOW',
    ],
    'api/cashflow' => [
      'slug' => 'TAR_CASHFLOW',
    ],
    'api/commonarea/*' => [
      'slug' => 'CAD_COMMONAREA',
    ],
    'api/commonarea' => [
      'slug' => 'CAD_COMMONAREA',
    ],
    'api/reservation/*' => [
      'slug' => 'CAD_RESERVATIONS',
    ],
    'api/reservation' => [
      'slug' => 'CAD_RESERVATIONS',
    ],
  ];

  private $permissionType = [
    'GET' => 'consultar',
    'POST' => 'inserir',
    'PUT' => 'alterar',
    'DELETE' => 'excluir',
  ];

  public function handle($request, Closure $next) {
    try {
      foreach ($this->permissions as $key => $value) {
        if ($request->is($key)) {
          if (!$request->user()->hasPermission($value['slug'], $this->permissionType[$request->method()])) {
            return $this->responseHttpError();
          }
        }
      }
    } catch (\Exception $e) {
      return $this->responseHttpError();
    }

    return $next($request);
  }

  private function responseHttpError() {
    return response()->json([
      'error' => 'Unauthorized'
    ], 401);
  }
}