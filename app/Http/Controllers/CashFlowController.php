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
        $query = Period::select(
            'periods.id', 
            'periods.name',
            'periods.status',
            DB::raw('YEAR(periods.start_date) as year'),
            DB::raw("COALESCE(
                SUM(
                    CASE WHEN type = 'E' THEN amount ELSE -amount END
                ), 0) as balance"
            ),
            DB::raw("COALESCE(
                    SUM(
                        CASE WHEN type = 'E' THEN amount ELSE 0 END
                    ), 0) as total_income"
                ),
            DB::raw("COALESCE(
                    SUM(
                        CASE WHEN type = 'S' THEN amount ELSE 0 END
                    ), 0) as total_expense"
                ),
            )
            ->leftJoin('cash_flows as cf', 'cf.period_id', '=', 'periods.id')
            ->groupBy('periods.id')
            ->orderBy('periods.start_date', 'desc');

        if ($request->has('year')) {
            $query->whereYear('periods.start_date', $request->year);
        }

        $cashFlow = $query->get();

        return response()->json($cashFlow);
    }

    public function get(Request $request, $periodId) {
        try {
            $period = Period::findOrFail($periodId)->load('cashFlows');
            $period->total_income = $period->cashFlows->where('type', 'E')->sum('amount');
            $period->total_expense = $period->cashFlows->where('type', 'S')->sum('amount');
            $period->balance = $period->total_income - $period->total_expense;

            return response()->json($period);
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
