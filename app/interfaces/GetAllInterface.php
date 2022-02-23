<?php

namespace App\Http\Interfaces;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;

interface GetAllInterface {
    public function getAll(): JsonResponse;
}
