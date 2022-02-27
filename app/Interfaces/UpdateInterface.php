<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

interface UpdateInterface {
    public function update(Request $request, $id): JsonResponse;
}
