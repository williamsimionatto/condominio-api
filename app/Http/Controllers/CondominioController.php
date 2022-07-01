<?php

namespace App\Http\Controllers;

use App\Helpers\CNPJValidator;
use App\Helpers\HasPermissions;
use App\Repository\Eloquent\CondominioRepository;
use App\Interfaces\DeleteInterface;
use App\Interfaces\GetAllInterface;
use App\Interfaces\GetByIdInterface;
use App\Interfaces\SaveInterface;
use App\Interfaces\UpdateInterface;
use App\Helpers\Validator;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CondominioController extends Controller implements GetAllInterface,
                                                         GetByIdInterface,
                                                         SaveInterface,
                                                         UpdateInterface,
                                                         DeleteInterface {
    private $repository;
    private $validator;
    private $cnpjValidator;
    private $hasPermissions;

    private $rules = [
        'name' => 'required|string|max:255',
        'cnpj' => 'required|string|max:255',
        'condominio2quartos' => 'required|numeric',
        'condominio3quartos' => 'required|numeric',
        'condominiosalacomercial'=> 'required|numeric',
        'valoragua'=> 'required|numeric',
        'valorsalaofestas'=> 'required|numeric',
        'valorlimpezasalaofestas'=> 'required|numeric',
        'valormudanca'=> 'required|numeric',
        'taxaboleto'=> 'required|numeric',
        'taxabasicaagua'=> 'required|numeric',
    ];

    public function __construct(
        CondominioRepository $repository, 
        Validator $validator, 
        CNPJValidator $cnpjValidator,
        HasPermissions $hasPermissions
    ) {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->cnpjValidator = $cnpjValidator;
        $this->hasPermissions = $hasPermissions;
    }

    public function getAll(Request $request): JsonResponse {
        if (!$this->hasPermissions->hasPermission($request->user()->perfil_id, 'CAD_CONDOMINIO', 'consultar')) {
            return response()->json('Not Found', 404);
        }

        $condominios = $this->repository->getAll();
        return response()->json($condominios);
    }

    public function getById(Request $request, $id): JsonResponse {
        if (!$this->hasPermissions->hasPermission($request->user()->perfil_id, 'CAD_CONDOMINIO', 'consultar')) {
            return response()->json('Not Found', 404);
        }

        $condominio = $this->repository->getById($id);
        return response()->json($condominio);
    }

    public function save(Request $request): JsonResponse {
        if (!$this->hasPermissions->hasPermission($request->user()->perfil_id, 'CAD_CONDOMINIO', 'inserir')) {
            return response()->json('Not Found', 404);
        }

        $data = $request->all();
        parent::validateFields($data, $this->rules);

        if (!$this->cnpjValidator->isValid($data['cnpj'])) {
            return response()->json(['message' => 'CNPJ inválido'], 500);
        }

        $condominio = $this->repository->save($data);

        return response()->json($condominio);
    }

    public function update(Request $request, $id): JsonResponse {
        if (!$this->hasPermissions->hasPermission($request->user()->perfil_id, 'CAD_CONDOMINIO', 'alterar')) {
            return response()->json('Not Found', 404);
        }

        $data = $request->all();
        parent::validateFields($data, $this->rules);

        if (!$this->cnpjValidator->isValid($data['cnpj'])) {
            return response()->json(['message' => 'CNPJ inválido'], 500);
        }

        $condominio = $this->repository->update($id, $data);

        return response()->json($condominio);
    }

    public function delete(Request $request, $id): JsonResponse {
        if (!$this->hasPermissions->hasPermission($request->user()->perfil_id, 'CAD_CONDOMINIO', 'excluir')) {
            return response()->json('Not Found', 404);
        }

        $condominio = $this->repository->delete($id);
        if ($condominio) {
            return response()->json($condominio);
        }

        return response()->json(['message' => 'Não foi possível excluir este condomínio'], 500);
    }
}
