<?php

namespace App\Repository\Eloquent;

use App\Models\HistoricoValoresCondominio;
use App\Repository\Interfaces\HistoricoValoresCondominioRepositoryInterface;

class HistoricoValoresCondominioRepository extends BaseRepository implements HistoricoValoresCondominioRepositoryInterface {
    protected $model;

    public function __construct(HistoricoValoresCondominio $model) {
        $this->model = $model;
    }

    public function model() {
        return HistoricoValoresCondominio::class;
    }
}
