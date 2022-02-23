<?php

namespace App\Http\Controllers;

use App\Helpers\Validator;
use App\Http\Interfaces\GetAllInterface;
use App\Repository\Eloquent\CondominioRepository;
use Illuminate\Http\Request;

class CondominioController extends Controller implements GetAllInterface {
    private $repository;
    private $validator;

    public function __construct(CondominioRepository $repository, Validator $validator) {
        $this->repository = $repository;
        $this->validator = $validator;
    }

    public function getAll() {
        $condominios = $this->repository->getAll();
        return response()->json($condominios);
    }
}
