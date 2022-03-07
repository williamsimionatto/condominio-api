<?php

namespace App\Repository\Interfaces;

use App\Repository\EloquentRepositoryInterface;

interface LeituraAguaRepositoryInterface extends EloquentRepositoryInterface {
    public function getByCondominio($id);
}
