<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Condomino extends Model {
    use HasFactory;
    protected $table = "condomino";

    protected $fillable = [
        'apartamento',
        'condomino',
        'nome',
        'cpf',
        'sindico',
        'tipo',
        'numeroquartos'
    ];

    public function leituraAgua() {
        return $this->hasMany(LeituraAgua::class, 'condominio');
    }
}
