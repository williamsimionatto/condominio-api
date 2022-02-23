<?php

namespace App\Http\Interfaces;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;

interface DeleteByIdInterface {
    public function deleteById(Model $model, int $id): JsonResponse;
}
