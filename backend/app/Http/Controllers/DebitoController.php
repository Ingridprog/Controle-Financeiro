<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Debito;
use App\Api\ApiMessege;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\DadosPessoaisController;

class DebitoController extends Controller
{
    private $debito;
    private $dadosPessoaisController;
   
    public function __construct(Debito $debito, DadosPessoaisController $dadosPessoaisController)
    {
        $this->debito = $debito;
        $this->dadosPessoaisController = $dadosPessoaisController;
    }

    public function index()
    {
        $debito = $this->debito->all();

        return response()->json([
            'data'=> $debito
        ], 200);
    }

    public function store(Request $request)
    {
        $data = $request->all();

        Validator::make($data, [
            'nome'           => ['string'],
            'valor'          => ['required'],
            'destinatario'   => ['string', 'nullable']
        ])->validate();

        if($data['transferencia'] == 1){
            $this->dadosPessoaisController->transferir($data['id_pessoa'], $data['destinatario'], $data['valor']);

            return response()->json([
                'messege' => "Transfêrencia concluída com sucesso!"
            ], 201);
        }
            
        else{
            try{
                $debito = $this->debito->create($data);
    
                $this->dadosPessoaisController->atualizarSaldo($data['valor'], $data['id_pessoa'], 2);
    
                return response()->json([
                    'messege'   => 'Débito adicionado com sucesso!',
                    'data'      => $debito
                ], 201);
    
            }catch(\Exception $e){
                $messege = new ApiMesseges($e->getMessage());
                return response()->json($messege->getMessege(), 400);
            }
        }
    }

    public function show($id)
    {
        try{
            $debito = $this->debito->findOrFail($id);

            return response()->json([
                'data' => $credito
            ], 200);
        }catch(\Execption $e){
            $messege = new ApiMesseges($e->getMessage());
            return response()->json($messege->getMessege(), 401);
        }
    }
}
