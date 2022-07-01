<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LeituraAguaReportController extends Controller {
    public function report(Request $request) {
        $dataInicial = $request->input('dataInicial');
        $dataFinal = $request->input('dataFinal');
        $condomino = $request->input('condomino');

        if ($condomino && !preg_match("/^(0|-*[1-9]+[0-9]*)$/", $condomino)) {
            return new JsonResponse(['message' => 'Condômino inválido'], 400);
        }

        $condomino = $condomino ? " AND c.id = ".$condomino : " AND TRUE";

        $results = DB::select(
            "SELECT la.dataleitura, c.id,
                    CONCAT(c.apartamento, ' - ', c.name) AS condominoName,
                    ABS(lav.consumo - COALESCE(sub.consumo, 0)) AS consumo,
                    (
                        (ABS(lav.consumo - COALESCE(sub.consumo, 0)) * hvc.valoragua) +
                        hvc.taxabasicaagua + hvc.taxaboleto + 
                        (CASE WHEN c.sindico = 'S' THEN 0.00
                            WHEN c.tipo = 'A' AND c.numeroquartos = 3 THEN hvc.condominio3quartos 
                            WHEN c.tipo = 'A' AND c.numeroquartos = 2 THEN hvc.condominio2quartos 
                            WHEN c.tipo = 'S' THEN hvc.condominiosalacomercial 
                        END) +
                        (hvc.valorsalaofestas * lav.qtdusosalao) + 
                        (hvc.valorlimpezasalaofestas * lav.qtdlimpezasalao) +
                        (hvc.valormudanca * lav.qtdmudanca)
                    ) AS valorTotal, DATEDIFF(la.dataleitura, sub.dataleitura) as diasConsumo,
                    DATE_SUB(la.dataleitura, INTERVAL 1 MONTH) as mesreferencia,
                    lad.leitura_agua_valores AS fileId, lad.nomearquivo AS fileName
            FROM leitura_agua la
            JOIN leitura_agua_valores lav ON la.id = lav.leitura_agua
            JOIN historico_valores_condominios hvc ON hvc.leitura = la.id
            LEFT JOIN leitura_agua_documentos lad ON lad.leitura_agua_valores = lav.id
            JOIN condomino c ON lav.condomino = c.id
            LEFT JOIN (
                SELECT sub_lav.consumo, 
                        CASE WHEN c.ativo = 'N' 
                                THEN (
                                    SELECT co.id 
                                    FROM condomino co 
                                    WHERE co.apartamento = c.apartamento AND co.ativo = 'S' 
                                    LIMIT 1 
                                )
                                ELSE sub_lav.condomino
                            END AS condomino, 
                        sub_la.dataleitura
                FROM leitura_agua_valores sub_lav
                JOIN leitura_agua sub_la ON sub_lav.leitura_agua  = sub_la.id
                JOIN condomino c ON sub_lav.condomino = c.id
            ) AS sub ON sub.condomino = lav.condomino AND EXTRACT(YEAR_MONTH FROM sub.dataleitura) = EXTRACT(YEAR_MONTH FROM DATE_SUB(la.dataleitura, INTERVAL 1 MONTH))
            WHERE TRUE AND DATE_SUB(la.dataleitura, INTERVAL 1 MONTH) BETWEEN :dataInicial AND :dataFinal $condomino
            GROUP BY la.dataleitura, lav.condomino
            ORDER BY la.dataleitura DESC, c.apartamento",
            [
                'dataInicial' => $dataInicial ? $dataInicial : date( 'Y' ) . '-01-01',
                'dataFinal' => $dataFinal ? $dataFinal : date( 'Y' ) . '-12-31',
            ],
            [
                'dataInicial' => \PDO::PARAM_STR,
                'dataFinal' => \PDO::PARAM_STR,
            ]
        );

        return response()->json($results);
    }
}
