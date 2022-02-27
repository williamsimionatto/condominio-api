<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeituraAguaValores extends Model {
    use HasFactory;

    protected $table = "leitura_agua_valores";

    protected $fillable = [
        'leitura_agua',
        'condomino',
        'consumo',
        'condominio2quartos',
        'condominio3quartos',
        'condominiosalacomercial',
        'valoragua',
        'valorsalaofestas',
        'valorlimpezasalaofestas',
        'valormudanca'
    ];

    public function leituraAgua() {
        return $this->belongsTo(LeituraAgua::class, 'leitura_agua');
    }
}