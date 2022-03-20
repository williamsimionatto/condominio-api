<?php

namespace App\Repository\Interfaces;

use App\Repository\EloquentRepositoryInterface;

interface LeituraAguaValoresRepositoryInterface extends EloquentRepositoryInterface {
    public function getCondominos($filter);
    public function getValoresCondominos($filter);
}
