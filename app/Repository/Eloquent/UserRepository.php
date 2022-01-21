<?php

namespace App\Repository\Eloquent;

use App\Models\User;
use App\Repository\Eloquent\BaseRepository;
use App\Repository\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;

class UserRepository  extends BaseRepository implements UserRepositoryInterface {
    protected $model;

    public function __construct(User $model) {
        $this->model = $model;
    }

    public function model() {
        return User::class;
    }

    public function getAll() {
        return $this->model::select('users.*', 'users.password as password_confirmation')->get();
    }

    public function getById($id) {
        return $this->model::select('users.*', 'users.password as password_confirmation')->where('id', $id)->first();
    }

    public function refreshPassword($id, $password) {
        $user = $this->model::find($id);
        $user->password = $password;
        $user->save();
        return $user;
    }

    public function verifyPassword($id, $password) {
        $user = $this->model::find($id);
        return Hash::check($password, $user->password);
    }
}