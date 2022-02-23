<?php

namespace App\Http\Interfaces;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

interface SaveInterface {
    public function save(Request $request): JsonResponse;
}
