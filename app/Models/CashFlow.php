<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashFlow extends Model {
    use HasFactory;
    protected $table = 'cash_flows';
    protected $fillable = ['period_id', 'type', 'description', 'amount', 'date'];

    public function period() {
        return $this->belongsTo('App\Models\Period');
    }
}
