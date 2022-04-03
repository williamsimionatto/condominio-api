<?php

namespace App\Http\Controllers;

use App\Models\LeituraAguaDocumentos;
use Illuminate\Http\Request;

class FileUploadController extends Controller {
    public function save(Request $request) {
        $data = $request->all();
        $file = $request->file('file');

        if ($file) {
            $pdf = new LeituraAguaDocumentos();
            $pdf->leitura_agua_valores = $data['leituraId'];
            $pdf->nomearquivo = $file->getClientOriginalName();
            $pdf->tipoanexo = $file->getClientOriginalExtension();
            $pdf->tamanho = $file->getSize();
            $pdf->arquivo = base64_encode(file_get_contents($file->getRealPath()));
            $save = $pdf->save();
            if ($save) {
                return response()->json(['success' => true, 'message' => 'Arquivo salvo com sucesso.'], 200);
            } else {
                return response()->json(['success' => false, 'message' => 'Erro ao salvar arquivo.'], 500);
            }
        }
    }
}
