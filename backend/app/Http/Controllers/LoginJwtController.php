<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Api\ApiMessege;
use Illuminate\Support\Facades\Validator;

class LoginJwtController extends Controller
{
    public function login(Request $request)
    {
        $credenciais = $request->all(['cpf', 'password']);

        Validator::make($credenciais, [
            'cpf' => 'required|string',
            'password' => 'required|string',
        ])->validate();

        if (!$token = auth('api')->attempt($credenciais)){

            $messege = new ApiMessege('Unauthorized');
            return response()->json($messege->getMessege(), 401);
        }

        return response()->json([
            'user' => auth('api')->user(),
            'token' => $token
        ]);
    }
}
