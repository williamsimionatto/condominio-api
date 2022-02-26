<?php

namespace App\Http\Controllers;

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
    private $rules = [
        'name' => 'required|string|max:255',
        'cnpj' => 'required|string|max:255',
        'condominio2quartos' => 'required|numeric',
        'condominio3quartos' => 'required|numeric',
        'condominiosalacomercial'=> 'required|numeric',
        'valoragua'=> 'required|numeric',
        'valorsalaofestas'=> 'required|numeric',
        'valorlimpezasalaofestas'=> 'required|numeric',
        'valormudanca'=> 'required|numeric'
    ];

    public function __construct(CondominioRepository $repository, Validator $validator) {
        $this->repository = $repository;
        $this->validator = $validator;
    }

    public function getAll(): JsonResponse {
        $condominios = $this->repository->getAll();
        return response()->json($condominios);
    }

    public function getById($id): JsonResponse {
        $condominio = $this->repository->getById($id);
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
        $this->validateFields($fields, $this->rules);

        $condominio = $this->repository->update($data, $id);

        return response()->json($condominio);
    }

    public function delete(Request $request, $id): JsonResponse {
        $condominio = $this->repository->deleteById($id);
        if ($condominio) {
            return response()->json($condominio);
        }

        return response()->json(['message' => 'Não foi possível excluir este condomínio'], 500);
    }

    private function validateFields(Array $data, Array $rules) {
        $isValid = $this->validator->validate($data, $rules);
        if ($isValid['fails']) {
            return response(['errors'=>$isValid['errors']], 422);
        }
    }
}
