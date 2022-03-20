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
        'dataleiutra'=> 'required|string',
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

    public function getAll(): JsonResponse {
        $leituras = $this->repository->getAll();
        return response()->json($leituras);
    }

    public function getById($id): JsonResponse {
        $leitura = $this->repository->getById($id);
        return response()->json($leitura);
    }

    public function getByCondominio($id): JsonResponse {
        $leituras = $this->repository->getByCondominio($id);
        return response()->json($leituras);
    }

    public function save(Request $request): JsonResponse {
        $data = $request->all();
        $this->validateFields($data, $this->rules);

        $leitura = $this->repository->save($data);

        $condominio = $this->repositoryCondominio->getById($data['condominio']);
        $sindico = $this->repositoryCondomino->getSindico();

        $historicoValores = [];
        $historicoValores['leitura'] = $leitura->id;
        $historicoValores['condominio2quartos'] = $condominio->condominio2quartos;
        $historicoValores['condominio3quartos'] = $condominio->condominio3quartos;
        $historicoValores['condominiosalacomercial'] = $condominio->condominiosalacomercial;
        $historicoValores['valoragua'] = $condominio->valoragua;
        $historicoValores['valorsalaofestas'] = $condominio->valorsalaofestas;
        $historicoValores['valorlimpezasalaofestas'] = $condominio->valorlimpezasalaofestas;
        $historicoValores['valormudanca'] = $condominio->valormudanca;
        $historicoValores['sindico'] = $sindico->id;
        $historicoValores['taxaboleto'] = $condominio->taxaboleto;
        $historicoValores['taxabasicaagua'] = $condominio->taxabasicaagua;

        $this->repositoryHistoricoValores->save($historicoValores);
        return response()->json($leitura);
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

    private function validateFields(Array $data, Array $rules) {
        $isValid = $this->validator->validate($data, $rules);
        if ($isValid['fails']) {
            return response(['errors'=>$isValid['errors']], 422);
        }
    }
}
