<?php

namespace App\Http\Controllers;

use App\Helpers\Validator;
use App\Interfaces\DeleteInterface;
use App\Interfaces\GetAllInterface;
use App\Interfaces\GetByIdInterface;
use App\Interfaces\SaveInterface;
use App\Interfaces\UpdateInterface;
use App\Repository\Eloquent\LeituraAguaRepository;
use Illuminate\Http\Request;

class LeituraAguaController extends Controller implements GetAllInterface,
                                                          GetByIdInterface,
                                                          SaveInterface,
                                                          UpdateInterface,
                                                          DeleteInterface {

    private $repository;
    private $validator;
    private $rules = [
        'condominio'=> 'required|numeric',
        'dataleiutra'=> 'required|string',
        'datavencimento'=> 'required|string',
    ];

    public function __construct(LeituraAguaRepository $repository, Validator $validator) {
        $this->repository = $repository;
        $this->validator = $validator;
    }

    public function getAll(): JsonResponse {
        $leituras = $this->repository->getAll();
        return response()->json($leituras);
    }

    public function getById($id): JsonResponse {
        $leitura = $this->repository->getById($id);
        return response()->json($leitura);
    }

    public function getByCondominio($id): JsonResponse {
        $leituras = $this->repository->getByCondominio($id);
        return response()->json($leituras);
    }

    public function save(Request $request): JsonResponse {
        $data = $request->all();
        $this->validateFields($data, $this->rules);

        $leitura = $this->repository->save($data);
        return response()->json($leitura);
    }

    public function update(Request $request, $id): JsonResponse {
        $data = $request->all();
        $this->validateFields($data, $this->rules);

        $leitura = $this->repository->update($data, $id);
        return response()->json($leitura);
    }

    public function delete($id): JsonResponse {
        $this->repository->delete($id);
        return response()->json(['message' => 'Leitura de água deletada com sucesso']);
    }

    private function validateFields(Array $data, Array $rules) {
        $isValid = $this->validator->validate($data, $rules);
        if ($isValid['fails']) {
            return response(['errors'=>$isValid['errors']], 422);
        }
    }
}
