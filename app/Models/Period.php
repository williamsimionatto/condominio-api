<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Period extends Model {
    use HasFactory;
    protected $table = "periods";
    protected $fillable = ['name', 'start_date', 'end_date', 'status'];
    protected $hidden = ['created_at', 'updated_at'];

    public function cashFlows() {
        return $this->hasMany('App\Models\CashFlow');
    }

    public function leituras() {
        return $this->hasMany(LeituraAgua::class, 'period_id');
    }
}
