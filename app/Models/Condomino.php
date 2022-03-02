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
        'name',
        'cpf',
        'sindico',
        'tipo',
        'numeroquartos'
    ];

    public function leituraAgua() {
        return $this->hasMany(LeituraAgua::class, 'condominio');
    }

    public function condominio() {
        return $this->belongsTo(Condominio::class, 'condominio');
    }
}
