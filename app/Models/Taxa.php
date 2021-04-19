<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Taxa extends Model
{
    use HasFactory;
    
    protected $table = 'taxas';
    protected $fillable = [
        'tipo',
        'valor',
        'total_ufir',
        'ufir_id',
    ];

    public function ufir()
    {
        return $this->belongsTo(Ufir::class);
    }

}
