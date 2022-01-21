<?php

namespace App\Repository;

interface UserRepositoryInterface extends EloquentRepositoryInterface {
    public function refreshPassword($id, $password);
    public function verifyPassword($id, $password);
}