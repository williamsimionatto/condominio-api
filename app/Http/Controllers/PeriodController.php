<?php

namespace App\Http\Controllers;

use App\Models\Period;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class PeriodController extends Controller {
    private $rules = [
        'start_date' => 'required|date',
        'end_date' => 'required|date',
        'status' => 'required|string|max:1',
    ];

    public function getAll(Request $request) {
        try {
            $periods = Period::all();
            return response()->json($periods);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getById(Request $request, $id) {
        try {
            $period = Period::findOrFail($id);
            return response()->json($period);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Período não encontrado'], 404);
        }
    }

    public function save(Request $request) {
        try {
            parent::validate($request, $this->rules);
            $period = Period::create($request->all());
            return response()->json($period);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id) {
        try {
            parent::validate($request, $this->rules);
            $period = Period::findOrFail($id);
            $period->update($request->all());
            return response()->json($period);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Período não encontrado'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function delete(Request $request, $id) {
        try {
            $period = Period::findOrFail($id);
            $period->delete();
            return response()->json(['message' => 'Período excluído com sucesso']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Período não encontrado'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
