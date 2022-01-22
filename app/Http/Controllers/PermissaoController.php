<?php

namespace App\Http\Controllers;

use App\Helpers\Validator;
use App\Repository\Eloquent\PermissaoRepository;
use Illuminate\Http\Request;

class PermissaoController extends Controller {
    private $repository;
    private $validator;
    private $rules = [
        'name' => 'required|string|max:255',
        'sigla' => 'required|string|max:255',
    ];

    public function __construct(PermissaoRepository $repository, Validator $validator) {
        $this->repository = $repository;
        $this->validator = $validator;
    }

    public function getAll(Request $request) {
        $perfils = $this->repository->getAll();
        return response()->json($perfils);
    }

    public function getById(Request $request, $id) {
        $perfil = $this->repository->getById($id);
        return response()->json($perfil);
    }

    public function save(Request $request) {
        $data = $request->all();
        $this->validateFields($data, $this->rules);

        $perfil = $this->repository->save($data);
        return response()->json($perfil);
    }

    public function update(Request $request, $id) {
        $fields = $request->only('name', 'sigla');
        $this->validateFields($fields, $this->rules);

        $perfil = $this->repository->update($id, $fields);
        return response()->json($perfil);
    }

    public function delete(Request $request, $id) {
        $perfil = $this->repository->delete($id);
        if ($perfil) {
            return response()->json($perfil);
        }

        return response('', 500);
    }

    private function validateFields(Array $data, Array $rules) {
        $isValid = $this->validator->validate($data, $rules);
        if ($isValid['fails']) {
            return response()->json($isValid['errors'], 422);
        }
    }
}