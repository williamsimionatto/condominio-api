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
            $pdf->nomearquivo = trim($file->getClientOriginalName());
            $pdf->tipoanexo = trim($file->getClientOriginalExtension());
            $pdf->tamanho = $file->getSize();
            $pdf->arquivo = base64_encode(file_get_contents($file->getRealPath()));
            $arquivo = LeituraAguaDocumentos::where('leitura_agua_valores', '=', $data['leituraId'])->first();

            if ($pdf->tamanho > 5242880) {
                return response()->json(['success'=>false, 'message' => 'O arquivo não pode ser maior que 5MB'], 400);
            }

            if ($pdf->tipoanexo != 'pdf') {
                return response()->json(['success'=>false, 'message' => 'O arquivo deve ser do tipo PDF'], 400);
            }

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
        if ($file && $file->arquivo) {
            $fileName = $file->nomearquivo;

            $file = base64_decode($file->arquivo);
            file_put_contents($fileName, $file);
    
            if (file_exists($fileName)) {
                return response()->download($fileName, $fileName, [
                    'Content-Length: ' . filesize($fileName),
                ], 'attachment');
            }
        }

        return response()->json(['success' => false, 'message' => 'Erro ao baixar arquivo.'], 500);
    }

    public function deleteFile(Request $request, $id) {
        $file = LeituraAguaDocumentos::where('leitura_agua_valores', '=', $id)->first();
        $delete = $file->delete();

        if ($delete) {
            return response()->json(['success' => true, 'message' => 'Arquivo excluído com sucesso.'], 200);
        } else {
            return response()->json(['success' => false, 'message' => 'Erro ao excluir arquivo.'], 500);
        }
    }
}
