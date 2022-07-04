<?php

namespace App\Http\Controllers;

use App\Repository\Eloquent\PerfilPermissaoRepository;
use Illuminate\Http\Request;

class PerfilPermissaoController extends Controller {
    private $repository;

    public function __construct(PerfilPermissaoRepository $repository) {
        $this->repository = $repository;
    }

    public function save(Request $request) {
        $data = $request->all();
        $perfil = $data[0]['perfil'];
        $this->repository->deletePermissoesByPerfil($perfil);

        foreach ($data as $index => $permissao) {
            $salvar = [
                'perfil' => $perfil,
                'permissao' => $permissao['permissoes']['permissao'],
                'consultar'=> $permissao['permissoes']['consultar'],
                'inserir' => $permissao['permissoes']['inserir'],
                'alterar' => $permissao['permissoes']['alterar'],
                'excluir' => $permissao['permissoes']['excluir'],
            ];

            $this->repository->save($salvar);
        }

        return response('', 200);
    }

    public function getPermissoesByPerfil(Request $request, $idPerfil) {
        $perfil = $this->repository->getPermissoesByPerfil($idPerfil);
        return response()->json($perfil);
    }

    public function deletePermissoesByPerfil(Request $request, $idPerfil) {
        $this->repository->deletePermissoesByPerfil($idPerfil);
        return response()->json(['success' => true]);
    }
}
