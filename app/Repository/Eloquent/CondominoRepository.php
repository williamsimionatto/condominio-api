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

    public function getbyCondominio($id) {
        return $this->model->where('condominio', $id)->get()->orderby('position', 'asc');
    }

    public function save($data): Condomino {
        $condomino = $this->model->find($data['id']);

        if (!$condomino) {
            $condomino = $this->model->create($data);
        } else {
            $condomino->update($data);
        }

        return $condomino;
    }

    public function getSindico() {
        return $this->model->where('sindico', 'S')->first();
    }
}
