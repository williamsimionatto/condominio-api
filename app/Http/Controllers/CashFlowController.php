<?php

namespace App\Http\Controllers;

use App\Helpers\Validator;
use App\Models\CashFlow;
use App\Models\Period;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function getAll(Request $request) {
        $cashFlows = CashFlow::select(
            'period_id', 'periods.name', 'type', 'amount',
            DB::raw("SUM(
                        CASE WHEN type = 'E' THEN amount ELSE -amount END
                    ) as balance"
                ),
            DB::raw("SUM(
                        CASE WHEN type = 'E' THEN amount ELSE 0 END
                    ) as total_income"
                ),
            DB::raw("SUM(
                        CASE WHEN type = 'S' THEN amount ELSE 0 END
                    ) as total_expense"
                ),
            )
            ->join('periods', 'periods.id', '=', 'cash_flows.period_id')
            ->groupBy('period_id')
            ->get();

        return response()->json($cashFlows);
    }

    public function get(Request $request, $periodId) {
        try {
            $cashFlow = Period::findOrFail($periodId)->load('cashFlows');
            return response()->json($cashFlow);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Período não encontrado'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        } 
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

    public function update(Request $request, $id) {
        try {
            $data = $request->only(['date', 'amount', 'description', 'type']);

            $this->validateFields($data, $this->rules);

            $cashFlow = CashFlow::findOrFail($id);
            $cashFlow->update($data);
            return response()->json($cashFlow);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Registro não encontrado'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function delete(Request $request, $id) {
        try {
            $cashFlow = CashFlow::findOrFail($id);
            $cashFlow->delete();
            return response()->json(['success' => 'Registro excluído com sucesso']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Registro não encontrado'], 404);
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
