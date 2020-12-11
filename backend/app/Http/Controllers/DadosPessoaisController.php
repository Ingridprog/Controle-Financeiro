<?php

namespace App\Http\Controllers;

use App\Api\ApiMessege;
use App\Dados_pessoais;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class DadosPessoaisController extends Controller
{
    private $dadosPessoais;

    public function __construct(Dados_pessoais $dadosPessoais)
    {
        $this->dadosPessoais = $dadosPessoais;
    }
  
    public function index()
    {
        $dadosPessoais = $this->dadosPessoais->all();

        return response()->json([
            'data' => $dadosPessoais
        ], 200);
    }

    
    public function store(Request $request)
    {
        $data = $request->all();
        Validator::make($data,[
            'nome'      =>['required', 'string'],
            'cpf'       =>['required', 'string'],
            'uf'        =>['string', 'nullable'],
            'telefone'  =>['string', 'nullable'],
            'email'     =>['string', 'nullable'],
            'saldo'     =>['nullable']
        ])->validate();

        try{
            $dadosPessoais = $this->dadosPessoais->create($data);

            return response()->json([
                'messege' => 'Cliente cadastrado com sucesso!',
                'data' => $dadosPessoais
            ], 201);

        }catch(\Exception $e){
            $messege = new ApiMesseges($e->getMessage());
            return response()->json($messege->getMessege(), 400);
        }
    }

    public function show($id)
    {
        try{
            $dadosPessoais = $this->dadosPessoais->findOrFail($id);

            return response()->json([
                'data' => $dadosPessoais
            ], 200);

        }catch(\Exception $e){
            $messege = new ApiMesseges($e->getMessage());
            return response()->json($messege->getMessege(), 404);
        }
    }

    public function update(Request $request, $id)
    {
        $data  = $request->all();
        Validator::make($data, [
            'nome'      =>['string'],
            'cpf'       =>['string'],
            'uf'        =>['string', 'nullable'],
            'telefone'  =>['string', 'nullable'],
            'email'     =>['string', 'nullable']
        ])->validate();

        try{
            $dadosPessoais = $this->dadosPessoais->findOrFail($id);

            $dadosPessoais->update($data);

            return response()->json([
                'messege' => 'Dados atualizados com sucesso!',
                'data' => $dadosPessoais
            ], 200);
        }catch(\Exception $e){
            $messege = new ApiMesseges($e->getMessage());
            return response()->json($messege->getMessege(), 400);
        }
    }

    public function destroy($id)
    {
        try{
            $dadosPessoais = $this->dadosPessoais->findOrFail($id);

            $dadosPessoais->delete();

            return response()->json([
                'messege' => 'Cliente excluído com sucesso!'
            ], 200);
        }catch(\Exception $e){
            $messege = new ApiMesseges($e->getMessage());
            return response()->json($messege->getMessege(), 400);
        }
    }

    public function atualizarSaldo($valor, $idPessoa, $tipo)
    {
        $dadosPessoais = $this->dadosPessoais->findOrFail($idPessoa);

        try{
            if($tipo == 1){
                $dadosPessoais->update(['saldo' => ($dadosPessoais['saldo'] + $valor)]);
            }else{
                if($valor <= $dadosPessoais['saldo']){
                    $dadosPessoais->update(['saldo' => ($dadosPessoais['saldo'] - $valor)]);
                }
            }
        }catch(\Exception $e){
            $messege = new ApiMesseges($e->getMessage());
            return response()->json($messege->getMessege(), 400);
        }

    }

    public function transferir($id,$destinario,$valor)
    {   
        $dest = $this->dadosPessoais->where('cpf',"=", $destinario)->get();
        $rem = $this->dadosPessoais->findOrFail($id);

        if($rem['saldo'] >= $valor){
            DB::table('dados_pessoais')->where('cpf', $destinario)->update(['saldo' => ($dest[0]['saldo']+$valor)]);

            DB::table('dados_pessoais')->where('id', $id)->update(['saldo' => ($rem['saldo']-$valor)]);
        }else{
            echo "ERRO";
        }

        
    }
}
