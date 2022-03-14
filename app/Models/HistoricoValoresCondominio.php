<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoricoValoresCondominio extends Model {
    use HasFactory;
    protected $table = "historico_valores_condominios";

    protected $fillable = [
        'condominio',
        'leitura',
        'condominio2quartos',
        'condominio3quartos',
        'condominiosalacomercial',
        'valoragua',
        'valorsalaofestas',
        'valorlimpezasalaofestas',
        'valormudanca',
    ];

    public function condominio() {
        return $this->belongsTo(Condominio::class, 'condominio');
    }

    public function leitura() {
        return $this->belongsTo(LeituraAgua::class, 'leitura');
    }
}
