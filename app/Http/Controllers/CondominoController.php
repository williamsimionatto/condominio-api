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
                                                        GetByIdInterface,
                                                        SaveInterface,
                                                        UpdateInterface,
                                                        DeleteInterface {
    private $repository;
    private $validator;
    private $rules = [
        'name' => 'required|string|max:255',
        'cpf' => 'required|string|max:255',
        'sindico' => 'required|boolean',
        'tipo' => 'required|string|max:1',
        'numeroquartos' => 'required|integer',
        'apartamento' => 'required|integer|string',
        'condominio' => 'required|integer'
    ];

    public function __construct(CondominoRepository $repository, Validator $validator) {
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
        $data->sindico = $data->sindico ? 'S' : 'N';

        $condominio = $this->repository->save($data);
        return response()->json($condominio);
    }

    public function update(Request $request, $id): JsonResponse {
        $data = $request->all();
        $this->validateFields($data, $this->rules);
        $data->sindico = $data->sindico ? 'S' : 'N';

        $condominio = $this->repository->update($id, $data);
        return response()->json($condominio);
    }

    public function delete(Request $request, $id): JsonResponse {
        return response('', 404)->json('');
    }

    private function validateFields($data, $rules) {
        $validator = $this->validator->make($data, $rules);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->all()], 500);
        }
    }
}
