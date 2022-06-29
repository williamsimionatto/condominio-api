<?php

namespace App\Http\Controllers;

use App\Helpers\Validator;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\CommonArea;

class CommonAreaController extends Controller {
    private $rules = [
        'name'=> 'required|string|max:255',
    ];

    public function getAll(Request $request) {
        $commonAreas = CommonArea::all();
        return response()->json($commonAreas);
    }

    public function getById(Request $request, $id) {
        try {
            $commonArea = CommonArea::findOrFail($id);
            return response()->json($commonArea);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Registro não econtrado'], 404);
        }
    }

    public function save(Request $request) {
        try {
            $data = $request->all();

            parent::validateFields($data, $this->rules);
    
            $commonArea = CommonArea::create($data);
            return response()->json($commonArea);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function update(Request $request, $id) {
        try {
            $data = $request->only('name');
            parent::validateFields($data, $this->rules);

            $commonArea = CommonArea::findOrFail($id)->update($data);
            return response()->json($commonArea);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Registro não econtrado'], 404);
        }
    }

    public function delete(Request $request, $id) {
        try {
            $commonArea = CommonArea::findOrFail($id)->delete();
            return response()->json($commonArea);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Registro não econtrado'], 404);
        }
    }
}
