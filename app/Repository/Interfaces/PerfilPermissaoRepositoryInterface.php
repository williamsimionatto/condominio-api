<?php

namespace App\Repository\Interfaces;

use App\Repository\EloquentRepositoryInterface;

interface PerfilPermissaoRepositoryInterface extends EloquentRepositoryInterface {
    public function getPermissoesByPerfil(Int $idPerfil);
    public function getPermissoesByPerfilAndSigla(Int $idPerfil, String $sigla);
    public function deletePermissoesByPerfil($idPerfil);
}
