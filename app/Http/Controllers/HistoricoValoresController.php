<?php

namespace App\Http\Controllers;

use App\Models\HistoricoValoresCondominio;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class HistoricoValoresController extends Controller {
  public function getByLeitura(Request $request, $id) {
    try {
      $historicoValores = HistoricoValoresCondominio::where('leitura', $id)->first();
      return response()->json($historicoValores, 200);
    } catch (ModelNotFoundException $e) {
      return response()->json(['error' => 'Registro não econtrado'], 404);
    } catch (\Exception $e) {
      return response()->json(['error' => $e->getMessage()], 500);
    }
  }
}