<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\LeituraAguaValores;

class LeituraAguaDocumentos extends Model {
    use HasFactory;
    protected $table = "leitura_agua_documentos";

    protected $fillable = [
        'leitura_agua_valores',
        'nomearquivo',
        'tipoanexo',
        'tamanho',
        'arquivo',
    ];

    public function leituraAguaValores() {
        return $this->belongsTo(LeituraAguaValores::class, 'leitura_agua_valores');
    }
}
