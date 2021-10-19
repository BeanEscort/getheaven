<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    protected $table = 'reservas';
    protected $fillable = [
        'cpf_cliente',
        'nome',
        'data',
        'obs',
        'obs1',
        'obs2',
        'quadra',
        'numero',
        'processo',
        'carneiro',
        'galeria',
        'tipo',
        'user_id',
         
    ];

}

