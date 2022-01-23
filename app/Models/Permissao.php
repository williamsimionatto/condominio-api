<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permissao extends Model {
    use HasFactory;
    protected $table = 'permissao';

    protected $fillable = [
        'name',
        'sigla',
    ];

    public function perfilPermissao() {
        return $this->hasMany(PerfilPermissao::class, 'permissao');
    }
}
