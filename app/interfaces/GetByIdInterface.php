<?php

namespace App\Http\Interfaces;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;

interface GetByIdInterface {
    public function getById(number $id): JsonResponse;
}
