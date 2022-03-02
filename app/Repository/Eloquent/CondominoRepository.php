<?php

namespace App\Repository\Eloquent;

use App\Models\Condomino;
use App\Repository\Interfaces\CondominoRepositoryInterface;

class CondominoRepository extends BaseRepository implements CondominoRepositoryInterface {
    protected $model;

    public function __construct(Condomino $model) {
        $this->model = $model;
    }

    public function model() {
        return Condomino::class;
    }

    public function save($data): Condomino {
        return $this->model->firstOrCreate($data);
    }
}
