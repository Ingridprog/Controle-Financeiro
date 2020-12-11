<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Debito extends Model
{
    protected $fillable = [
        'nome', 'transferencia', 'valor', 'destinatario', 'id_pessoa'
    ];
}
