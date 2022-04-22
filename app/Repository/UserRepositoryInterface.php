<?php

namespace App\Repository;

interface UserRepositoryInterface extends EloquentRepositoryInterface {
    public function getByEmail($email);
    public function refreshPassword($id, $password);
    public function verifyPassword($id, $password);
    public function inactive($cpf);
}