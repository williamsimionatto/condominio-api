<?php

namespace App\Repository\Eloquent;

use App\Models\LeituraAgua;
use App\Repository\Interfaces\LeituraAguaRepositoryInterface;

class LeituraAguaRepository extends BaseRepository implements LeituraAguaRepositoryInterface {
    protected $model;

    public function __construct(LeituraAgua $model) {
        $this->model = $model;
    }

    public function model() {
        return LeituraAgua::class;
    }

    public function getByCondominio($id) {
        $leituras = $this->model->where('condominio', $id)->get();
        return $leituras;
    }
}
