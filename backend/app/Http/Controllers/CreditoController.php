<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Credito;
use App\Api\ApiMessege;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\DadosPessoaisController;

class CreditoController extends Controller
{
    private $credito;
    private $dadosPessoaisController;

    public function __construct(Credito $credito, DadosPessoaisController $dadosPessoaisController)
    {
        $this->credito = $credito;
        $this->dadosPessoaisController = $dadosPessoaisController;   
    }
  
    public function index()
    {
        $credito = $this->credito->all();

        return response()->json([
            'data' => $credito
        ], 200);
    }

    public function store(Request $request)
    {
        $data = $request->all();

        Validator::make($data, [
            'nome'      => ['required', 'string'],
            'valor'     => ['required'],
            'remetente' => ['string', 'nullable']
        ])->validate();

        try{
            $credito = $this->credito->create($data);

            $this->dadosPessoaisController->atualizarSaldo($data['valor'], $data['id_pessoa'], 1);

            return response()->json([
                'messege'   => 'Crédito adicionado com sucesso!',
                'data'      => $credito
            ], 201);
        }catch(\Exception $e){
            $messege = new ApiMesseges($e->getMessage());
            return response()->json($messege->getMessege(), 400);
        }
    }

    public function show($id)
    {
        try{
            $credito = $this->credito->findOrFail($id);

            return response()->json([
                'data' => $credito
            ], 200);
        }catch(\Execption $e){
            $messege = new ApiMesseges($e->getMessage());
            return response()->json($messege->getMessege(), 401);
        }
    }
}
