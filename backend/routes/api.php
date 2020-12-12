<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function(){
    Route::post('login', 'LoginJwtController@login')->name('login');
    Route::post('dadospessoais', 'DadosPessoaisController@store');

    Route::group(['middleware' => ['jwt.auth']], function(){
        Route::name('dadospessoais.')->group(function () {
            Route::resource('dadospessoais', 'DadosPessoaisController')->only([
                'index', 'show', 'update', 'destroy'
            ]);
        });

        Route::resource('credito', 'CreditoController');
        Route::resource('debito', 'DebitoController');

    });
});

