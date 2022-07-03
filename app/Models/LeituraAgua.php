<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Period;
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
        return $this->belongsTo(Condominio::class, 'condominio');
    }

    public function valores() {
        return $this->hasMany(LeituraAguaValores::class, 'leitura_agua');
    }

    public function periodo() {
        return $this->belongsTo(Period::class, 'period_id');
    }
}
