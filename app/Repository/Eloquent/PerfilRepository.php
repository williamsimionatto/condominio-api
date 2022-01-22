<?php

namespace App\Repository\Eloquent;

use App\Models\Perfil;
use App\Repository\Interfaces\PerfilRepositoryInterface;

class PerfilRepository extends BaseRepository implements PerfilRepositoryInterface {
    protected $model;

    public function __construct(Perfil $model) {
        $this->model = $model;
    }

    public function model() {
        return Perfil::class;
    }
}