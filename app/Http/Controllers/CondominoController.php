<?php

namespace App\Http\Controllers;

use App\Interfaces\DeleteInterface;
use App\Interfaces\GetAllInterface;
use App\Interfaces\GetByIdInterface;
use App\Interfaces\SaveInterface;
use App\Interfaces\UpdateInterface;
use App\Repository\Eloquent\CondominoRepository;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Helpers\Validator;

class CondominoController extends Controller implements GetAllInterface,
                                                        SaveInterface,
                                                        UpdateInterface,
                                                        DeleteInterface {
    private $repository;
    private $validator;
    private $hasPermissions;

    private $rules = [
        'name' => 'required|string|max:255',
        'cpf' => 'required|string|max:255',
        'sindico' => 'required|boolean',
        'tipo' => 'required|string|max:1',
        'numeroquartos' => 'required|integer',
        'apartamento' => 'required|integer|string',
        'condominio' => 'required|integer',
        'ativo' => 'required|string|max:1',
    ];

    public function __construct(
        CondominoRepository $repository, 
        Validator $validator,
        HasPermissions $hasPermissions
    ) {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->hasPermissions = $hasPermissions;
    }

    public function getAll(Request $request): JsonResponse {
        $condominios = $this->repository->getAll();
        return response()->json($condominios);
    }

    public function getByCondomino(Request $request, $id): JsonResponse {
        $condominio = $this->repository->getbyCondominio($id);
        return response()->json($condominio);
    }

    public function save(Request $request): JsonResponse {
        $data = $request->all();
        $this->validateFields($data, $this->rules);

        $condominio = $this->repository->save($data);
        return response()->json($condominio);
    }

    public function update(Request $request, $id): JsonResponse {
        $data = $request->all();
        $this->validateFields($data, $this->rules);

        $condominio = $this->repository->update($id, $data);
        return response()->json($condominio);
    }

    public function delete(Request $request, $id): JsonResponse {
        return response('', 404)->json('');
    }

    private function validateFields(Array $data, Array $rules) {
        $isValid = $this->validator->validate($data, $rules);
        if ($isValid['fails']) {
            return response(['errors'=>$isValid['errors']], 422);
        }
    }
}
