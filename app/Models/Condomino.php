<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Condomino extends Model {
    use HasFactory;

    $table = "condomino";

    protected $fillable = [
        'apartamento',
        'condomino',
        'nome',
        'cpf',
        'sindico',
        'tipo',
        'numeroquartos'
    ];
}
