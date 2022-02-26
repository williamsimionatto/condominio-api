<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

interface DeleteInterface {
    public function delete(Request $request, $id): JsonResponse;
}
