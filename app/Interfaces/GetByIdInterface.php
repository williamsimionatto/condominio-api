<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

interface GetByIdInterface {
    public function getById(Request $request, number $id): JsonResponse;
}
