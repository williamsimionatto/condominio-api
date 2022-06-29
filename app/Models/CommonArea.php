<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommonArea extends Model {
    use HasFactory;
    protected $table = "common_areas";
    protected $fillable = ['name'];
}
