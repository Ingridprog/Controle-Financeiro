<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Credito extends Model
{
    protected $fillable = [
        'nome', 'transferencia', 'valor', 'remetente', 'id_pessoa'
    ];

    public function cliente()
    {
        return $this->belongsTo(User::class, 'id_pessoa');
    }
}
