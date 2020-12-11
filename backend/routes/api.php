<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::prefix('v1')->group(function(){
    Route::resource('dadospessoais', 'DadosPessoaisController');
    Route::resource('credito', 'CreditoController');
    Route::resource('debito', 'DebitoController');
});