<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ReservationController extends Controller {
	private $rules = [
		'condomino_id'=> 'required|integer',
		'common_area_id'=> 'required|integer',
		'date'=> 'required|date',
	];

	public function getAll() {
		$reservations = Reservation::all()->load('condomino')->load('commonArea');
		return response()->json($reservations);
	}

	public function getById($id) {
		try {
			$reservation = Reservation::findOrFail($id)->load('condomino')->load('commonArea');
			return response()->json($reservation);
		} catch (ModelNotFoundException $e) {
			return response()->json(['error'=>'Registro não encontrado'], 404);
		}
	}

	public function save(Request $request) {
		try {
			$data = $request->all();
			parent::validateFields($data, $this->rules);
			$reservation = Reservation::create($data);
			return response()->json($reservation);
		} catch (\Exception $e) {
			return response()->json(['error' => $e->getMessage()], 500);
		}
	}

	public function update(Request $request, $id) {
		try {
			$data = $request->only('condomino_id', 'common_area_id', 'date');
			parent::validateFields($data, $this->rules);
			$reservation = Reservation::findOrFail($id)->update($data);
			return response()->json($reservation);
		} catch (ModelNotFoundException $e) {
			return response()->json(['error'=>'Registro não encontrado'], 404);
		} catch (\Exception $e) {
			return response()->json(['error' => $e->getMessage()], 500);
		}
	}

	public function delete($id) {
		try {
			Reservation::findOrFail($id)->delete();
			return response()->json([
				'message' => 'Registro excluído com sucesso'
			]);
		} catch (ModelNotFoundException $e) {
			return response()->json(['error'=>'Registro não encontrado'], 404);
		} catch (\Exception $e) {
			return response()->json(['error' => $e->getMessage()], 500);
		}
	}
}
