<?php

namespace App\Repository\Eloquent;

use App\Models\Perfil;
use App\Models\PerfilPermissao;
use App\Models\Permissao;
use App\Repository\Interfaces\PerfilPermissaoRepositoryInterface;
use Illuminate\Support\Facades\DB;

class PerfilPermissaoRepository extends BaseRepository implements PerfilPermissaoRepositoryInterface {
    protected $model;

    public function __construct(PerfilPermissao $model) {
        $this->model = $model;
    }

    public function model() {
        return PerfilPermissao::class;
    }

    public function getPermissoesByPerfil(Int $idPerfil, $optionsFilters = ['permissao.id', 'permissao.name', 'perfilpermisao.perfil']) {
        $optionsFilters = !empty($optionsFilters) ? $optionsFilters : [];

        $filters = array_merge($optionsFilters,
                               ['permissao.sigla',
                                DB::raw("COALESCE(perfilpermisao.consultar, 'N') AS consultar"),
                                DB::raw("COALESCE(perfilpermisao.inserir, 'N') AS inserir"),
                                DB::raw("COALESCE(perfilpermisao.alterar, 'N') AS alterar"),
                                DB::raw("COALESCE(perfilpermisao.excluir, 'N') AS excluir")]);

        $permissoes = Permissao::select($filters)
            ->leftjoin('perfilpermisao', function($join) use ($idPerfil) {
                $join->on('perfilpermisao.permissao', '=', 'permissao.id')
                    ->where('perfilpermisao.perfil', '=', $idPerfil);
            })
            ->orderBy('permissao.name')
            ->get();

        return $permissoes;
    }

    public function deletePermissoesByPerfil($idPerfil) {
        return $this->model->where('perfil', $idPerfil)->delete();
    }
}