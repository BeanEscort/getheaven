<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Funeraria extends Model
{
    use HasFactory;

    protected $table = 'funerarias';
    protected $fillable = [
        'nome',
    ];

    /* public function pessoas()
    {
        return $this->hasMany(\App\Models\Tenant\Pessoa::class);
    } */
}
