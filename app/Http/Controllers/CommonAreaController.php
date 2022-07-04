<?php

namespace App\Http\Controllers;

use App\Helpers\Validator;
use Illuminate\Http\Request;
use App\Models\CommonArea;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CommonAreaController extends Controller {
    private $rules = [
        'name'=> 'required|string|max:255',
    ];

    public function __construct(Validator $validator) {
        $this->validator = $validator;
    }

    public function getAll(Request $request) {
        try {
            $commonAreas = CommonArea::all();
            return response()->json($commonAreas);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getById(Request $request, $id) {
        try {
            $commonArea = CommonArea::findOrFail($id);
            return response()->json($commonArea);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Registro não econtrado'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function save(Request $request) {
        try {
            $data = $request->all();

            $this->validateFields($data, $this->rules);
    
            $commonArea = CommonArea::create($data);
            return response()->json($commonArea);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id) {
        try {
            $data = $request->only('name');
            $this->validateFields($data, $this->rules);

            $commonArea = CommonArea::findOrFail($id)->update($data);
            return response()->json($commonArea);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Registro não econtrado'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function delete(Request $request, $id) {
        try {
            $commonArea = CommonArea::findOrFail($id)->delete();
            return response()->json($commonArea);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Registro não econtrado'], 404);
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
