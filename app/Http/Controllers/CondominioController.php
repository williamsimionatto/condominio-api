<?php

namespace App\Http\Controllers;

use App\Helpers\CNPJValidator;
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

    public function __construct(CondominioRepository $repository, Validator $validator, CNPJValidator $cnpjValidator) {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->cnpjValidator = $cnpjValidator;
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

        if (!$this->cnpjValidator->isValid($data['cnpj'])) {
            return response()->json(['message' => 'CNPJ inválido'], 500);
        }

        $condominio = $this->repository->save($data);

        return response()->json($condominio);
    }

    public function update(Request $request, $id): JsonResponse {
        $data = $request->all();
        $this->validateFields($data, $this->rules);

        if (!$this->cnpjValidator->isValid($data['cnpj'])) {
            return response()->json(['message' => 'CNPJ inválido'], 500);
        }

        $condominio = $this->repository->update($id, $data);

        return response()->json($condominio);
    }

    public function delete(Request $request, $id): JsonResponse {
        $condominio = $this->repository->delete($id);
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
