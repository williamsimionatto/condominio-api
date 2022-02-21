<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Condominio extends Model {
    use HasFactory;
    protected $table = "condominio";

    protected $fillable = [
        'name',
        'cnpj',
        'condominio2quartos',
        'condominio3quartos',
        'condominiosalacomercial',
        'valoragua',
        'valorsalaofestas',
        'valorlimpezasalaofestas',
        'valormudanca'
    ];

    public function condominos() {
        return $this->hasMany(Condomino::class, 'condominio');
    }
}
