<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Condominio;

class LeituraAgua extends Model {
    use HasFactory;
    protected $table = "leitura_agua";

    protected $fillable = [
        'condominio',
        'dataleitura',
        'datavencimento',
        'period_id',
    ];

    public function condominio() {
        return $this->belongsTo(Condomino::class, 'condominio');
    }

    public function valores() {
        return $this->hasMany(LeituraAguaValores::class, 'leitura_agua');
    }

    public function periodo() {
        return $this->belongsTo(Periodo::class, 'period_id');
    }
}
