<?php

namespace App\Http\Controllers;

use App\Models\Condominio;
use App\Models\LeituraAguaValores;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class LeituraAguaValoresController extends Controller {
    public function __construct() {
        
    }

    public function save(Request $request) {
        $data = $request->all();
        $data['leitura_agua'] = $data['leituraagua'];
        $condominio = Condominio::find($data['condominio']);
        $data['condomino'] = $data['condominoId'];
        $data['consumo'] = $data['consumo'];
        $data['qtdusosalao'] = $data['qtdusosalao'];
        $data['qtdlimpezasalao'] = $data['qtdlimpezasalao'];
        $data['qtdmudanca'] = $data['qtdmudanca'];

        $result = LeituraAguaValores::create($data);
        return response()->json($result);
    }

    public function getCondominos(Request $request) {
        $date = $request->get('date', date('Y-m-d'));

        $results = DB::select(
            "SELECT '' AS id, '' AS leituraagua,
                    CONCAT(c.apartamento, ' - ', c.name) as condomino,
                    CASE WHEN c.sindico = 'S' THEN 0.00
                        WHEN c.tipo = 'A' AND c.numeroquartos = 3 THEN co.condominio3quartos
                        WHEN c.tipo = 'A' AND c.numeroquartos = 2 THEN co.condominio2quartos 
                        WHEN c.tipo = 'S' THEN co.condominiosalacomercial
                    END valorcondominio,
                    COALESCE(sub.consumo, 0) AS consumoAnterior, COALESCE(sub.consumo, 0) AS consumoAtual, 
                    0 consumo, 0 AS qtdusosalao, 0 AS qtlimpezasalao, 0 qtdmundanca        
            FROM condomino c
            JOIN condominio co ON c.condominio = co.id
            LEFT JOIN (
                SELECT lav.*
                FROM leitura_agua_valores lav
                JOIN leitura_agua la ON lav.leitura_agua  = la.id
                WHERE EXTRACT(YEAR_MONTH FROM la.dataleitura) = EXTRACT(YEAR_MONTH FROM DATE_SUB(:dataLeitura, INTERVAL 1 MONTH))
            ) AS sub ON sub.condomino = c.id
            WHERE c.ativo = :flAtivo",
            [
                'dataLeitura' => $date,
                'flAtivo' => 'S'
            ],
            [
                'dataLeitura' => 'date',
                'flAtivo' => 'string'
            ]
        );

        return response()->json($results);
    }

    public function getValoresCondominos(Request $request) {
        $data = $request->all();
        $results = [];
        // $results = DB::select(
        //         "SELECT la.id, lav.leitura_agua AS leituraagua,
        //             CONCAT(c.apartamento , '- ', c.name) AS condomino,
        //             CASE WHEN c.sindico = 'S' THEN 0.00
        //                 WHEN c.tipo = 'A' AND c.numeroquartos = 3 THEN co.condominio3quartos
        //                 WHEN c.tipo = 'A' AND c.numeroquartos = 2 THEN co.condominio2quartos 
        //                 WHEN c.tipo = 'S' THEN co.condominiosalacomercial 
        //                 END valorcondominio, COALESCE(sub.consumo, 0) AS consumoAnterior, lav.consumo AS consumoAtual, ABS(lav.consumo - COALESCE(sub.consumo, 0)) AS consumo,
        //                 co.valoragua, lav.valorsalaofestas, lav.valorlimpezasalaofestas, lav.valormudanca, co.taxaboleto, 
        //                 co.taxabasicaagua, 0 total, c.id  AS condominoId
        //         FROM leitura_agua la
        //         JOIN leitura_agua_valores lav ON la.id = lav.leitura_agua
        //         JOIN condomino c ON c.id = lav.condomino 
        //         JOIN condominio co ON co.id = la.condominio
        //         LEFT JOIN (
        //             SELECT lav.*
        //             FROM leitura_agua_valores lav
        //             JOIN leitura_agua la ON lav.leitura_agua  = la.id
        //             WHERE EXTRACT(YEAR_MONTH FROM la.dataleitura) = EXTRACT(YEAR_MONTH FROM DATE_SUB(:dataLeitura, INTERVAL 1 MONTH))
        //         ) AS sub ON sub.condomino = c.id
        //         WHERE lav.leitura_agua = :idLeitura",
        //     [
        //         'idLeitura' => $data['idLeitura'],
        //         'dataLeitura' => $data['dataLeitura']
        //     ],
        //     [
        //         'idLeitura' => 'int',
        //         'dataLeitura' => 'date'
        //     ]
        // );

        return response()->json($results);
    }
}
