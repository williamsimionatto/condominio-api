<?php

namespace App\Http\Controllers;

use App\Models\LeituraAguaDocumentos;
use Facade\FlareClient\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            $arquivo = LeituraAguaDocumentos::where('leitura_agua_valores', '=', $data['leituraId'])->first();
            if ($arquivo) {
                $arquivo->delete();
            }

            $save = $pdf->save();

            if ($save) {
                return response()->json(['success' => true, 'message' => 'Arquivo salvo com sucesso.', 'fileId'=>$pdf->id], 200);
            } else {
                return response()->json(['success' => false, 'message' => 'Erro ao salvar arquivo.'], 500);
            }
        }
    }

    public function downloadFile(Request $request, $id) {
        $file = LeituraAguaDocumentos::where('leitura_agua_valores', '=', $id)->first();
        $fileName = $file->nomearquivo;
    }
}