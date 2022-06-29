<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model {
    use HasFactory;

    protected $table = 'reservations';
    protected $fillable = ['condomino_id', 'common_area_id', 'date'];

    public function condomino() {
        return $this->belongsTo(Condomino::class);
    }

    public function commonArea() {
        return $this->belongsTo(CommonArea::class, 'common_area_id');
    }
}
