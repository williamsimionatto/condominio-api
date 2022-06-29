<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model {
    use HasFactory;

    protected $table = 'reservations';
    protected $fillable = ['condomino_id', 'common_area_id', 'date'];

    public function condomino() {
        return $this->hasOne(Condomino::class, 'condomino_id');
    }

    public function commonArea() {
        return $this->hasOne(CommonArea::class, 'common_area_id');
    }
}
