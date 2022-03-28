<?php
namespace App\Helpers;

use App\Repository\Eloquent\PerfilPermissaoRepository;

class HasPermissions {
    protected $perfilPermissaoRepository;

    public function __construct(PerfilPermissaoRepository $perfilPermissaoRepository) {
        $this->perfilPermissaoRepository = $perfilPermissaoRepository;
    }

    public function hasPermission($perfil, $sigla, $tipo) {
        $permissao = $this->perfilPermissaoRepository->getPermissoesByPerfilAndSigla($perfil, $sigla);

        if (empty($permissao)) {
            return false;
        }

        return $permissao[0][$tipo] === 'S';
    }
}