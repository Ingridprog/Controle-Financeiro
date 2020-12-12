<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Credito;
use App\Api\ApiMessege;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\DadosPessoaisController;
use App\User;

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
        $credito = auth('api')->user()->creditos;

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

            $data['id_pessoa'] = auth('api')->user()->id;

            $credito = $this->credito->create($data);

            $this->dadosPessoaisController->atualizarSaldo($data['valor'], $data['id_pessoa'], 1);

            return response()->json([
                'messege'   => 'Crédito adicionado com sucesso!',
                'data'      => $credito
            ], 201);
        }catch(\Exception $e){
            $messege = new ApiMessege($e->getMessage());
            return response()->json($messege->getMessege(), 400);
        }
    }

    // public function show($idPessoa)
    // {
    //     try{
    //         $data = $this->credito->where('id_pessoa', '=', $idPessoa)->get();

    //         return response()->json([
    //             'data' => $data
    //         ], 200);

    //     }catch(\Exception $e){
    //         $messege = new ApiMessege($e->getMessage());
    //         return response()->json($messege->getMessege(), 400);
    //     }
    // }

    public function show($id)
    {
        try{
            $credito = auth('api')->user()->creditos()->findOrFail($id);

            return response()->json([
                'data' => $credito
            ], 200);
        }catch(\Exception $e){
            $messege = new ApiMessege($e->getMessage());
            return response()->json($messege->getMessege(), 401);
        }
    }
}
