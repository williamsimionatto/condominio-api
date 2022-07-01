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
use App\Helpers\HasPermissions;
use App\Repository\Eloquent\UserRepository;

class CondominoController extends Controller implements GetAllInterface,
                                                        SaveInterface,
                                                        UpdateInterface,
                                                        DeleteInterface {
    private $repository;
    private $validator;
    private $hasPermissions;
    private $userRepository;

    private $rules = [
        'name' => 'required|string|max:255',
        'cpf' => 'required|string|max:255',
        'sindico' => 'required|boolean',
        'tipo' => 'required|string|max:1',
        'numeroquartos' => 'required|integer',
        'apartamento' => 'required|integer|string',
        'condominio' => 'required|integer',
        'ativo' => 'required|string|max:1',
        'position' => 'required|integer|min:1|max:15',
    ];

    public function __construct(
        CondominoRepository $repository,
        Validator $validator,
        HasPermissions $hasPermissions,
        UserRepository $userRepository
    ) {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->hasPermissions = $hasPermissions;
        $this->userRepository = $userRepository;
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
        try {
            $data = $request->all();
            parent::validateFields($data, $this->rules);
            $condomino = $this->repository->save($data);

            if ($condomino->ativo == 'N') {
                $this->userRepository->inactive($condomino->cpf);
                $condomino['inactive_at'] = date('Y-m-d H:i:s');
                $condomino = $this->repository->save($condomino);
            }

            return response()->json($condomino);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id): JsonResponse {
        try {
            $data = $request->all();
            parent::validateFields($data, $this->rules);

            $condomino = $this->repository->update($id, $data);
            if ($condomino->ativo == 'N') {
                $this->userRepository->inactive($condomino->cpf);
            }

            return response()->json($condomino);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function delete(Request $request, $id): JsonResponse {
        return response('', 404)->json('');
    }
}
