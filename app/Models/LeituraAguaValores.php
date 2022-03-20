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
        'valorcondominio',
        'qtdusosalao',
        'qtdlimpezasalao',
        'qtdmudanca',
    ];

    public function leituraAgua() {
        return $this->belongsTo(LeituraAgua::class, 'leitura_agua');
    }
}
