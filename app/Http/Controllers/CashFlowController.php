<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CashFlowController extends Controller {
    private $rules = [
        'date' => 'required|date',
        'amount' => 'required|numeric',
        'description' => 'required|string',
        'type' => 'required|string|',
    ];
}
