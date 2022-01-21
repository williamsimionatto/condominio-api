<?php

namespace App\Http\Controllers;

use App\Repository\Eloquent\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller {
    private $repository;

    public function __construct(UserRepository $repository) {
        $this->repository = $repository;
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
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response(['errors'=>$validator->errors()->all()], 422);
        }

        $password = Hash::make($request->password);
        $request->offsetSet('password', $password);

        $user = $this->repository->save($request->all());
        return response()->json($user);
    }

    public function update(Request $request, $id) {
        $fields = $request->only('name', 'email', 'active');

        $validator = Validator::make($fields, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255'
        ]);

        if ($validator->fails()) {
            return response(['errors'=>$validator->errors()->all()], 422);
        }

        $user = $this->repository->update($id, $fields);
        return response()->json($user);
    }

    public function delete(Request $request, $id) {
        $user = $this->repository->delete($id);
        return response()->json($user);
    }

    public function refreshPassword(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response(['errors'=>$validator->errors()->all()], 422);
        }

        $algo = Hash::make($request->password);
        $user = $this->repository->refreshPassword($id, $algo);
        return response()->json($user);
    }

    public function verifyPassword(Request $request, $id) {
        return $this->repository->verifyPassword($id, $request->password);
    }
}
