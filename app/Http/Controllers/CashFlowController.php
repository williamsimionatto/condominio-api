<?php

namespace App\Http\Controllers;

use App\Helpers\Validator;
use App\Models\CashFlow;
use Illuminate\Http\Request;

class CashFlowController extends Controller {
    private $validator;
    private $rules = [
        'date' => 'required|date',
        'amount' => 'required|numeric',
        'description' => 'required|string',
        'type' => 'required|string|',
        'period_id' => 'required|integer',
    ];

    public function __construct(Validator $validator) {
        $this->validator = $validator;
    }

    public function save(Request $request) {
        try {
            $data = $request->all();
    
            $this->validateFields($data, $this->rules);
    
            $cashFlow = CashFlow::create($data);
            return response()->json($cashFlow);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    protected function validateFields(Array $data, Array $rules) {
        $isValid = $this->validator->validate($data, $rules);
        if ($isValid['fails']) {
            throw new \Exception($isValid['errors'][0]);
        }
    }
}
