<?php

namespace App\Repository\Eloquent;

use App\Models\Condominio;
use App\Repository\Interfaces\CondominioRepositoryInterface;

class CondominioRepository extends BaseRepository implements CondominioRepositoryInterface {
    protected $model;

    public function __construct(Condominio $model) {
        $this->model = $model;
    }

    public function model() {
        return Condominio::class;
    }
}
