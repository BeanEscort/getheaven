<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Empresa extends Model
{
    use HasFactory;

    protected $table = 'empresas';
    protected $fillable = [
        'domain',
        'orgao',
	'logo',
    ];

    public function logo(){
	return Pessoa::find(1);
    }
}

