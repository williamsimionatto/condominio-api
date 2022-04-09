<?php

namespace App\Http\Controllers;

use App\Models\Condominio;
use App\Models\LeituraAguaValores;
use App\Repository\Eloquent\LeituraAguaValoresRepository;
use Illuminate\Http\Request;

class LeituraAguaValoresController extends Controller {
    private $leituraAguaValoresRepository;
    private $condominioRepository;

    public function __construct(
        LeituraAguaValoresRepository $leituraAguaValores
    ) {
        $this->leituraAguaValoresRepository = $leituraAguaValores;
    }

    public function save(Request $request) {
        $data = $request->all();
        $data['leitura_agua'] = $data['leituraagua'];
        $data['condomino'] = $data['condominoId'];
        $data['consumo'] = $data['consumo'];
        $data['qtdusosalao'] = $data['qtdusosalao'];
        $data['qtdlimpezasalao'] = $data['qtdlimpezasalao'];
        $data['qtdmudanca'] = $data['qtdmudanca'];

        $result = $this->leituraAguaValoresRepository->save($data);
        return response()->json($result);
    }

    public function update(Request $request, $id) {
        $update = [];
        $data = $request->all();
        $update['leitura_agua'] = $data['leituraagua'];
        $update['condomino'] = $data['condominoId'];
        $update['consumo'] = $data['consumo'];
        $update['qtdusosalao'] = $data['qtdusosalao'];
        $update['qtdlimpezasalao'] = $data['qtdlimpezasalao'];
        $update['qtdmudanca'] = $data['qtdmudanca'];

        $leitura = $this->leituraAguaValoresRepository->get([
            'leitura_agua' => $update['leitura_agua'],
            'condomino' => $update['condomino']
        ])->update($update);

        return response()->json($leitura);
        // if ($leitura->count() > 0) {
        //     $leitura->update($update);
        // }

        // return response(204);
    }

    public function getCondominos(Request $request) {
        $filter = [
            'date'=>$request->get('date', date('Y-m-d'))
        ];

        $results = $this->leituraAguaValoresRepository->getCondominos($filter);
        return response()->json($results);
    }

    public function getValoresCondominos(Request $request) {
        $date = $request->get('date', date('Y-m-d'));
        $idLeitura = $request->get('id', 0);

        $filter = [
            'date' => $date,
            'id' => $idLeitura
        ];

        $results = $this->leituraAguaValoresRepository->getValoresCondominos($filter);
        return response()->json($results);
    }
}
