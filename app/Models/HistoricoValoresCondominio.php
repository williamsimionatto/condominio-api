<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoricoValoresCondominio extends Model {
    use HasFactory;
    protected $table = "historico_valores_condominios";

    protected $fillable = [
        'leitura',
        'condominio2quartos',
        'condominio3quartos',
        'condominiosalacomercial',
        'valoragua',
        'valorsalaofestas',
        'valorlimpezasalaofestas',
        'valormudanca',
        'taxaboleto',
        'taxabasicaagua',
        'sindico'
    ];

    public function leitura() {
        return $this->belongsTo(LeituraAgua::class, 'leitura');
    }
}
