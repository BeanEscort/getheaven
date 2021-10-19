<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cemiterio extends Model
{
    use HasFactory;

    protected $table = 'cemiterios';
    protected $fillable = [
        'nome',
    ];
}
