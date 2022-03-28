<?php
namespace App\Helpers;

interface HasPermissionsInterface {
    public function hasPermission($perfil, $sigla, $tipo);
}
