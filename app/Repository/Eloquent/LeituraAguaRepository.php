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
        return $this->model
            ->with('periodo')
            ->with('condominio')
            ->orderBy('leitura_agua.dataleitura', 'desc')
            ->get();
    }

    public function getByCondominio($id) {
        $leituras = $this->model->where('condominio', $id)->get();
        return $leituras;
    }

    public function isUniqueLeituraMonth($condominio, $dataleitura) {
        $month = date('m', strtotime($dataleitura));
        $year = date('Y', strtotime($dataleitura));
        $dataInicial = date('Y-m-d', strtotime($year . '-' . $month . '-01'));
        $dataFinal = date('Y-m-t', strtotime($dataInicial));

        $leitura = $this->model->where('condominio', $condominio)
                ->whereBetween('dataleitura', 
                    [$dataInicial, $dataFinal]
                )
                ->first();

        return ($leitura && $leitura->count() == 0) || $leitura; 
    }
}
