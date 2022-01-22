<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Perfil;
use App\Models\Permissao;
class PerfilPermissao extends Model {
    use HasFactory;
    protected $table = 'perfilpermisao';

    protected $fillable = [
        'perfil',
        'permissao',
        'consultar',
        'inserir',
        'alterar',
        'excluir',
    ];

    public function perfil() {
        return $this->belongsTo(Perfil::class, 'perfil');
    }

    public function permissao() {
        return $this->belongsTo(Permissao::class, 'permissao');
    }
}
