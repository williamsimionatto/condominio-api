<?php

namespace App\Http\Controllers;

use App\Helpers\Validator;
use App\Repository\Eloquent\UserRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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
        try {
            $users = $this->repository->getAll();
            return response()->json($users);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getById(Request $request, $id) {
        try {
            $user = $this->repository->getById($id);
            return response()->json($user);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Registro não econtrado'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
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

        try {
            $this->validateFields($data, $rules);
    
            $algo = Hash::make($request->password);
            $request->offsetSet('password', $algo);
    
            $user = $this->repository->save($request->all());
            return response()->json($user);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id) {
        $fields = $request->only('name', 'email', 'active', 'perfil_id', 'cpf');

        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255'
        ];

        try {
            $this->validateFields($fields, $rules);

            $user = $this->repository->update($id, $fields);
            return response()->json($user);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Registro não econtrado'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function delete(Request $request, $id) {
        try {
            $user = $this->repository->delete($id);
            return response()->json($user);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Registro não econtrado'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function refreshPassword(Request $request, $id) {
        $data = $request->all();
        $rules = [
            'password' => 'required|string|min:6|confirmed',
        ];

        try {
            $this->validateFields($data, $rules);
    
            $algo = Hash::make($request->password);
            $user = $this->repository->refreshPassword($id, $algo);
            return response()->json($user);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Registro não econtrado'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function verifyPassword(Request $request, $id) {
        $igual = $this->repository->verifyPassword($id, $request->password);
        return response()->json(['ok'=>$igual]);
    }

    protected function validateFields(Array $data, Array $rules) {
		$isValid = $this->validator->validate($data, $rules);
		if ($isValid['fails']) {
			throw new \Exception($isValid['errors'][0]);
		}
	}
}
