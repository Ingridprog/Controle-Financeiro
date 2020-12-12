<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Debito extends Model
{
    protected $fillable = [
        'nome', 'transferencia', 'valor', 'destinatario', 'id_pessoa'
    ];

    public function cliente()
    {
        return $this->belongsTo(User::class, 'id_pessoa');
    }
}
