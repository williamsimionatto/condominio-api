<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perfil extends Model {
    use HasFactory;
    protected $table = "perfil";
    protected $fillable = ['name'];

    public function users() {
        return $this->hasMany(User::class, 'perfil_id');
    }

    public function perfilPermissao() {
        return $this->hasMany(PerfilPermissao::class, 'perfil');
    }
}
