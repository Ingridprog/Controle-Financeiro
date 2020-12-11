<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dados_pessoais extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'nome', 'cpf', 'uf','telefone', 'email', 'saldo'
    ];
}
