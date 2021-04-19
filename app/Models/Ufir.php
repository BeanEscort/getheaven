<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ufir extends Model
{
    use HasFactory;

    protected $table = 'ufirs';
    protected $fillable = [
        'valor_ufir',
        'valor_anterior',
        'ano',
    ];
}
