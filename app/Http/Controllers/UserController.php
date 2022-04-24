<?php

namespace App\Http\Controllers;

use App\Helpers\Validator;
use App\Repository\Eloquent\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller {
    private $repository;
    private $validator;

    public function __construct(UserRepository $repository, Validator $validator) {
        $this->repository = $repository;
        $this->validator = $validator;
    }

    public function getAll(Request $request) {
        $users = $this->repository->getAll();
        return response()->json($users);
    }

    public function getById(Request $request, $id) {
        $user = $this->repository->getById($id);
        return response()->json($user);
    }

    public function save(Request $request) {
        $data = $request->all();
        $rules = [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6|confirmed',
                'perfil_id' => 'required|integer',
                'cpf' => 'required|string|max:14|',
            ];
        
        $this->validateFields($data, $rules);

        $algo = Hash::make($request->password);
        $request->offsetSet('password', $algo);

        $user = $this->repository->save($request->all());
        return response()->json($user);
    }

    public function update(Request $request, $id) {
        $fields = $request->only('name', 'email', 'active', 'perfil_id', 'cpf');

        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255'
        ];

        $this->validateFields($fields, $rules);

        $user = $this->repository->update($id, $fields);
        return response()->json($user);
    }

    public function delete(Request $request, $id) {
        $user = $this->repository->delete($id);
        return response()->json($user);
    }

    public function refreshPassword(Request $request, $id) {
        $data = $request->all();
        $rules = [
            'password' => 'required|string|min:6|confirmed',
        ];

        $this->validateFields($data, $rules);

        $algo = Hash::make($request->password);
        $user = $this->repository->refreshPassword($id, $algo);
        return response()->json($user);
    }

    public function verifyPassword(Request $request, $id) {
        $igual = $this->repository->verifyPassword($id, $request->password);
        return response()->json(['ok'=>$igual]);
    }

    private function validateFields(Array $data, Array $rules) {
        $isValid = $this->validator->validate($data, $rules);
        if ($isValid['fails']) {
            return response(['errors'=>$isValid['errors']], 422);
        }
    }
}
