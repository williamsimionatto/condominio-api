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

    public function getAll() {
        return $this->model->join('condominio', 'condominio.id', '=', 'leitura_agua.condominio')
            ->select('leitura_agua.*', 'condominio.name as condominio', 'condominio.id as condominioid')
            ->get();
    }

    public function getByCondominio($id) {
        $leituras = $this->model->where('condominio', $id)->get();
        return $leituras;
    }
}
