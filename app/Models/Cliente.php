<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $table = 'clientes';
    protected $fillable = [
        'cpf',
        'nome',
        'data_cadastro',
        'cep',
        'endereco',
        'nro',
        'complemento',
        'bairro',
        'uf',
        'cidade',
        'celular1',
        'celular2',
        'telefone',
        'user_id', 
    ];

    public function pessoas()
    {
        return $this->hasMany(\App\Models\Pessoa::class);
    }
}
