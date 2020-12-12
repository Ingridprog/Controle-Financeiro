<?php

namespace App\Http\Controllers;

use App\Api\ApiMessege;
use App\Dados_pessoais;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\User;

class DadosPessoaisController extends Controller
{
    private $dadosPessoais;

    public function __construct(User $dadosPessoais)
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
            'saldo'     =>['nullable'],
            'password'  =>['required', 'string']
        ])->validate();

        try{

            $data['password'] = bcrypt($data['password']);

            $dadosPessoais = $this->dadosPessoais->create($data);

            return response()->json([
                'messege' => 'Cliente cadastrado com sucesso!',
                'data' => $dadosPessoais
            ], 201);

        }catch(\Exception $e){
            $messege = new ApiMessege($e->getMessage());
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
            $messege = new ApiMessege($e->getMessage());
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
            'email'     =>['string', 'nullable'],
            'password'  =>['string']
        ])->validate();

        try{
            $dadosPessoais = $this->dadosPessoais->findOrFail($id);

            if($request->has('password') && $request->get('password')){
                $data['password'] = bcrypt($data['password']);
            } else {
                unset($data['password']);
            }

            $dadosPessoais->update($data);

            return response()->json([
                'messege' => 'Dados atualizados com sucesso!',
                'data' => $dadosPessoais
            ], 200);
        }catch(\Exception $e){
            $messege = new ApiMessege($e->getMessage());
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
            $messege = new ApiMessege($e->getMessage());
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
            $messege = new ApiMessege($e->getMessage());
            return response()->json($messege->getMessege(), 400);
        }

    }

    public function transferir($id,$destinario,$valor)
    {
        $dest = $this->dadosPessoais->where('cpf',"=", $destinario)->get();
        $rem = $this->dadosPessoais->findOrFail($id);

        if($rem['saldo'] >= $valor){
            DB::table('users')->where('cpf', $destinario)->update(['saldo' => ($dest[0]['saldo']+$valor)]);

            DB::table('creditos')->insert([
                'nome' => "Recebimento de DOC",
                'transferencia' => 1,
                'valor' => $valor,
                'remetente' => $rem['nome'],
                'id_pessoa' => $dest[0]['id'],
            ]);

            DB::table('users')->where('id', $id)->update(['saldo' => ($rem['saldo']-$valor)]);
        }else{
            echo "ERRO";
        }
    }
 
    

    public function verificarSaldo($id){

        try{
            $data = $this->dadosPessoais->findOrFail($id);

            $saldo = $data['saldo'];

            return $saldo;

        }catch(\Exception $e){
            $messege = new ApiMessege($e->getMessage());
            return response()->json($messege->getMessege(), 400);
        }
        
    }
}
