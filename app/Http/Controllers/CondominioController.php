<?php

namespace App\Http\Controllers;

use App\Helpers\Validator;
use App\Http\Interfaces\GetAllInterface;
use App\Http\Interfaces\GetByIdInterface;
use App\Http\Interfaces\SaveInterface;
use App\Http\Interfaces\UpdateInterface;
use App\Http\Interfaces\DeleteByIdInterface;
use App\Repository\Eloquent\CondominioRepository;
use Illuminate\Http\Request;

class CondominioController extends Controller implements GetAllInterface,
                                                         GetByIdInterface,
                                                         SaveInterface,
                                                         UpdateInterface,
                                                         DeleteByIdInterface {
    private $repository;
    private $validator;

    public function __construct(CondominioRepository $repository, Validator $validator) {
        $this->repository = $repository;
        $this->validator = $validator;
    }

    public function getAll() {
        $condominios = $this->repository->getAll();
        return response()->json($condominios);
    }

    public function getById($id) {
        $condominio = $this->repository->getById($id);
        return response()->json($condominio);
    }

    public function save(Request $request) {
        $data = $request->all();
        $validation = $this->validator->validate($data);
        if ($validation->fails()) {
            return response()->json($validation->errors(), 500);
        }

        $condominio = $this->repository->save($data);
    }

    public function update(Request $request, $id) {
        $data = $request->all();
        $validation = $this->validator->validate($data);

        if ($validation->fails()) {
            return response()->json($validation->errors(), 500);
        }

        $condominio = $this->repository->update($data, $id);

        return response()->json($condominio);
    }

    public function deleteById($id) {
        $condominio = $this->repository->deleteById($id);
        if ($condominio) {
            return response()->json($condominio);
        }
        
        return response()->json(['message' => 'Não foi possível excluir este condomínio'], 500);
    }
}
