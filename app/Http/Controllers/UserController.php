<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
class UserController extends Controller {
    public function getAll(Request $request) {
        $users = User::all();
        return response()->json($users);
    }

    public function getById(Request $request, $id) {
        $user = User::find($id);
        return response()->json($user);
    }

    public function save(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response(['errors'=>$validator->errors()->all()], 422);
        }

        $password = Hash::make($request->password);
        $request->offsetSet('password', $password);

        $user = User::create($request->all());
        return response()->json($user);
    }

    public function update(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response(['errors'=>$validator->errors()->all()], 422);
        }

        $user = User::find($id);
        $user->update($request->all());
        return response()->json($user);
    }

    public function delete(Request $request, $id) {
        $user = User::find($id);
        $user->delete();
        return response()->json($user);
    }
}
