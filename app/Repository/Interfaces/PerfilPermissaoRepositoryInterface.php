<?php

namespace App\Repository\Interfaces;

use App\Repository\EloquentRepositoryInterface;

interface PerfilPermissaoRepositoryInterface extends EloquentRepositoryInterface {
    public function getPermissoesByPerfil(Int $idPerfil);
    public function deletePermissoesByPerfil($idPerfil);
}
