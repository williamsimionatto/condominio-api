<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class LeituraAguaValoresController extends Controller {
    public function __construct() {
        
    }

    public function getCondominos(Request $request) {
        $data = $request->all();

        $results = DB::select(
            "SELECT la.id, lav.leitura_agua AS leituraagua,
                    CONCAT(c.condominio, '- ', c.name) AS condomino,
                    CASE WHEN c.sindico = 'S' THEN 0.00
                        WHEN c.tipo = 'A' AND c.numeroquartos = 3 THEN co.condominio3quartos
                        WHEN c.tipo = 'A' AND c.numeroquartos = 2 THEN co.condominio2quartos 
                        WHEN c.tipo = 'S' THEN co.condominiosalacomercial 
                    END valorcondominio, sub.consumo AS consumoAnterior, sub.consumo AS consumoAtual, 0 consumo,
                    co.valoragua, lav.valorsalaofestas, lav.valorlimpezasalaofestas, lav.valormudanca, co.taxaboleto, 
                    co.taxabasicaagua, 0 total
            FROM leitura_agua la
            JOIN leitura_agua_valores lav ON la.id = lav.leitura_agua
            JOIN condomino c ON c.id = lav.id
            JOIN condominio co ON co.id = la.condominio
            JOIN (
                SELECT lav.*
                FROM leitura_agua_valores lav
                JOIN leitura_agua la ON lav.leitura_agua  = la.id
                WHERE EXTRACT(YEAR_MONTH FROM la.dataleitura) = EXTRACT(YEAR_MONTH FROM DATE_SUB(:dataLeitura, INTERVAL 1 MONTH))
            ) AS sub ON sub.condomino = c.id 
            WHERE la.id = :idLeitura",
            [
                'idLeitura' => $data['idLeitura'],
                'dataLeitura' => $data['dataLeitura']
            ],
            [
                'idLeitura' => 'integer',
                'dataLeitura' => 'date'
            ]
        );

        return response()->json($results);
    }
}