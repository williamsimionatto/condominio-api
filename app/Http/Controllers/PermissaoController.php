<?php

namespace App\Http\Controllers;

use App\Helpers\Validator;
use App\Repository\Eloquent\PermissaoRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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
        try {
            $perfis = $this->repository->getAll();
            return response()->json($perfis);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getById(Request $request, $id) {
        try {
            $perfil = $this->repository->getById($id);
            return response()->json($perfil);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Registro não econtrado'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function save(Request $request) {
        try {
            $data = $request->all();
            $this->validateFields($data, $this->rules);

            $perfil = $this->repository->save($data);
            return response()->json($perfil);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id) {
        try {
            $fields = $request->only('name', 'sigla');
            $this->validateFields($fields, $this->rules);
    
            $perfil = $this->repository->update($id, $fields);
            return response()->json($perfil);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Registro não econtrado'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function delete(Request $request, $id) {
        $perfil = $this->repository->delete($id);
        if ($perfil) {
            return response()->json($perfil);
        }

        return response('', 500);
    }

    protected function validateFields(Array $data, Array $rules) {
        $isValid = $this->validator->validate($data, $rules);
        if ($isValid['fails']) {
            throw new \Exception($isValid['errors'][0]);
        }
    }
}