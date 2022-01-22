<?php

namespace App\Repository\Eloquent;

use App\Models\Permissao;
use App\Repository\Interfaces\PermissaoRepositoryInterface;

class PermissaoRepository extends BaseRepository implements PermissaoRepositoryInterface {
    protected $model;

    public function __construct(Permissao $model) {
        $this->model = $model;
    }

    public function model() {
        return Permissao::class;
    }
}