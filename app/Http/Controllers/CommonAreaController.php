<?php

namespace App\Http\Controllers;

use App\Helpers\Validator;

class CommonAreaController extends Controller {
    private $validator;
    private $rules = [
        'name'=> 'required|string|max:255',
    ];

    public function __construct(Validator $validator) {
        $this->validator = $validator;
    }

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
        $data = $request->all();

        super::validateFields($data, $this->rules);

        $commonArea = CommonArea::create($data);
        return response()->json($commonArea);
    }

    public function update(Request $request, $id) {
        $fields = $request->only('name');

        super::validateFields($data, $this->rules);

        $commonArea = CommonArea::findOrFail($id);
        $commonArea->update($fields);
        return response()->json($commonArea);
    }

    public function delete(Request $request, $id) {
        $commonArea = CommonArea::findOrFail($id);
        $commonArea->delete();
        return response()->json($commonArea);
    }
}
