<?php

namespace App\Http\Controllers;

use App\Helpers\Validator;
use App\Repository\Eloquent\PerfilPermissaoRepository;
use Illuminate\Http\Request;

class PerfilPermissaoController extends Controller {
    private $repository;
    private $validator;
    private $rules = [
        'perfil' => 'required|integer',
        'permissao' => 'required|integer',
        'permissoes'=> 'required|array',
    ];

    public function __construct(PerfilPermissaoRepository $repository, Validator $validator) {
        $this->repository = $repository;
        $this->validator = $validator;
    }

    public function save(Request $request) {
        $data = $request->all();
        $isValid = $this->validateFields($data, $this->rules);

        if ($isValid['fails']) {
            return response()->json($isValid['errors'], 400);
        }

        $this->repository->deletePermissoesByPerfil($data['perfil']);

        foreach ($data['permissoes'] as $permissao) {
            $permissao['perfil'] = $data['perfil'];
            $permissao['permissao'] = $data['permissao'];	
            $this->repository->save($permissao);
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

    public function validateFields(Array $data, Array $rules) {
        return $this->validator->validate($data, $rules);
    }
}
