<?php

namespace App\Http\Interfaces;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

interface UpateInterface {
    public function update(Request $request, $id): JsonResponse;
}
