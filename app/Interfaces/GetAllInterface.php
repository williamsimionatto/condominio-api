<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

interface GetAllInterface {
    public function getAll(Request $request): JsonResponse;
    
}
