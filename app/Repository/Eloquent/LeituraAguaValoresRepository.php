<?php

namespace App\Repository\Eloquent;

use App\Models\LeituraAguaValores;
use App\Repository\Interfaces\LeituraAguaValoresRepositoryInterface;

use Illuminate\Support\Facades\DB;

class LeituraAguaValoresRepository extends BaseRepository implements LeituraAguaValoresRepositoryInterface {
    protected $model;

    public function __construct(LeituraAguaValores $model) {
        $this->model = $model;
    }

    public function model() {
        return LeituraAguaValores::class;
    }

    public function get($filter) {
        $leituraAgua = LeituraAguaValores::where($filter);
        return $leituraAgua;
    }

    public function getCondominos($filter) {
        $results = DB::select(
            "SELECT '' AS id, '' AS leituraagua,
                    CONCAT(c.apartamento, ' - ', c.name) as condomino,
                    CASE WHEN c.sindico = 'S' THEN 0.00
                        WHEN c.tipo = 'A' AND c.numeroquartos = 3 THEN co.condominio3quartos
                        WHEN c.tipo = 'A' AND c.numeroquartos = 2 THEN co.condominio2quartos 
                        WHEN c.tipo = 'S' THEN co.condominiosalacomercial
                    END valorcondominio,
                    COALESCE(sub.consumo, 0) AS consumoAnterior, COALESCE(sub.consumo, 0) AS consumoAtual, 
                    0 consumo, 0 AS qtdusosalao, 0 AS qtdlimpezasalao, 0 qtdmudanca, c.id as condominoId      
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
                'dataLeitura' => $filter['date'],
                'flAtivo' => 'S'
            ]
        );

        return $results;
    }

    public function getValoresCondominos($filter) {
        $results = DB::select(
            "SELECT la.id, lav.id AS leituraagua,
                    c.id AS condominoId,
                    CONCAT(c.apartamento, ' - ', c.name)	AS condomino,
                    CASE WHEN c.sindico = 'S' THEN 0.00
                        WHEN c.tipo = 'A' AND c.numeroquartos = 3 THEN hvc.condominio3quartos 
                        WHEN c.tipo = 'A' AND c.numeroquartos = 2 THEN hvc.condominio2quartos 
                        WHEN c.tipo = 'S' THEN hvc.condominiosalacomercial 
                    END valorcondominio,
                    COALESCE(sub.consumo, 0) AS consumoAnterior, lav.consumo AS consumoAtual,
                    ABS(lav.consumo - COALESCE(sub.consumo, 0)) AS consumo, 
                    lav.qtdusosalao, lav.qtdlimpezasalao, lav.qtdmudanca,
                    hvc.valoragua, hvc.taxaboleto, hvc.taxabasicaagua, 0 AS total,
                    c.id as condominoId, lad.id as fileId, lad.nomearquivo as fileName
            FROM leitura_agua la
            JOIN leitura_agua_valores lav ON la.id = lav.leitura_agua
            JOIN historico_valores_condominios hvc ON hvc.leitura = la.id
            LEFT JOIN leitura_agua_documentos lad ON lad.leitura_agua_valores = lav.id
            JOIN condomino c ON lav.condomino = c.id
            LEFT JOIN (
                SELECT lav.*
                FROM leitura_agua_valores lav
                JOIN leitura_agua la ON lav.leitura_agua  = la.id
                WHERE EXTRACT(YEAR_MONTH FROM la.dataleitura) = EXTRACT(YEAR_MONTH FROM DATE_SUB(:dataLeitura, INTERVAL 1 MONTH))
            ) AS sub ON sub.condomino = lav.condomino
            WHERE lav.leitura_agua = :idLeitura",
            [
                'idLeitura' => $filter['id'],
                'dataLeitura' => $filter['date']
            ]
        );
        
        return $results;
    }
}