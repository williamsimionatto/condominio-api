<?php

namespace App\Http\Controllers;

use App\Helpers\Validator;
use App\Interfaces\DeleteInterface;
use App\Interfaces\GetAllInterface;
use App\Interfaces\GetByIdInterface;
use App\Interfaces\SaveInterface;
use App\Interfaces\UpdateInterface;
use App\Models\HistoricoValoresCondominio;
use App\Repository\Eloquent\CondominioRepository;
use App\Repository\Eloquent\CondominoRepository;
use App\Repository\Eloquent\HistoricoValoresCondominioRepository;
use App\Repository\Eloquent\LeituraAguaRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Error;

class LeituraAguaController extends Controller implements GetAllInterface,
                                                          GetByIdInterface,
                                                          SaveInterface,
                                                          UpdateInterface,
                                                          DeleteInterface {

    private $repository;
    private $repositoryHistoricoValores;
    private $repositoryCondominio;
    private $repositoryCondomino;
    private $validator;
    private $rules = [
        'condominio'=> 'required|numeric',
        'dataleitura'=> 'required|string',
        'datavencimento'=> 'required|string',
    ];

    public function __construct(
        LeituraAguaRepository $repository, Validator $validator,
        HistoricoValoresCondominioRepository $repositoryHistoricoValores,
        CondominioRepository $repositoryCondominio,
        CondominoRepository $repositoryCondomino
    ) {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->repositoryHistoricoValores = $repositoryHistoricoValores;
        $this->repositoryCondominio = $repositoryCondominio;
        $this->repositoryCondomino = $repositoryCondomino;
    }

    public function getAll(Request $request): JsonResponse {
        try {
            $leituras = $this->repository->getAll();
            return response()->json($leituras);
        } catch (Error $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getById(Request $request, $id): JsonResponse {
        try {
            $leitura = $this->repository->getById($id);
            return response()->json($leitura);
        } catch (Error $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getByCondominio($id): JsonResponse {
        try {
            $leituras = $this->repository->getByCondominio($id);
            return response()->json($leituras);
        } catch (Error $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function save(Request $request): JsonResponse {
        try {
            $data = $request->all();
            $this->validateFields($data, $this->rules);

            if ($this->repository->isUniqueLeituraMonth($data['condominio'], $data['dataleitura'])) {
                throw new Error('Já existe uma leitura para mês-ano informado!');
            }

            $leitura = $this->repository->save($data);

            $condominio = $this->repositoryCondominio->getById($data['condominio']);
            $sindico = $this->repositoryCondomino->getSindico();

            $historicoValores = [
                'leitura' => $leitura->id,
                'condominio2quartos' => $condominio->condominio2quartos,
                'condominio3quartos' => $condominio->condominio3quartos,
                'condominiosalacomercial' => $condominio->condominiosalacomercial,
                'valoragua' => $condominio->valoragua,
                'valorsalaofestas' => $condominio->valorsalaofestas,
                'valorlimpezasalaofestas' => $condominio->valorlimpezasalaofestas,
                'valormudanca' => $condominio->valormudanca,
                'sindico'=> $sindico->id,
                'taxaboleto'=> $condominio->taxaboleto,
                'taxabasicaagua'=> $condominio->taxabasicaagua,
            ];

            $this->repositoryHistoricoValores->save($historicoValores);
            return response()->json($leitura);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id): JsonResponse {
        $data = $request->all();
        $this->validateFields($data, $this->rules);

        $leitura = $this->repository->update($id, $data);
        return response()->json($leitura);
    }

    public function delete(Request $request, $id): JsonResponse {
        $condominio = $this->repository->delete($id);
        if ($condominio) {
            return response()->json($condominio);
        }

        return response()->json(['message' => 'Não foi possível excluir este condomínio'], 500);
    }

    public function isUniqueLeituraMonth(Request $request) {
        try {
            $condominio = $request->input('condominio');
            $dataleitura = $request->input('dataleitura');
            if (!$condominio || !$dataleitura) {
                throw new Error('Parâmetros inválidos!');
            }

            $leitura = $this->repository->isUniqueLeituraMonth($condominio, $dataleitura);
            return response()->json(['unique'=>!$leitura]);
        } catch (Error $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    protected function validateFields(Array $data, Array $rules) {
        $isValid = $this->validator->validate($data, $rules);
        if ($isValid['fails']) {
            throw new \Exception($isValid['errors'][0]);
        }
    }
}
