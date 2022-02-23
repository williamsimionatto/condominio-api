<?php

namespace App\Http\Interfaces;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Client\Request;
use Illuminate\Http\JsonResponse;

interface DeleteInterface {
    public function delete(Request $request, int $id): JsonResponse;
}
