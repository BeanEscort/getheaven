<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pessoa extends Model
{
    use HasFactory;

    protected $table = 'pessoas';
    protected $dates = [
        'dt_obito',
        'dt_sepultamento',
    ];
    
    protected $fillable = [

        'nome',         
        'cliente_id',
        'mae' ,
        'pai' ,
        'idade' ,
        'quadra' ,
        'numero' ,
        'processo',
        'tipo_id',
        'valor_taxa',
        'pago',
        'cor',
        'sexo',
        'dt_obito' ,            
        'dt_sepultamento' ,
        'hora_sepultamento',
        'latitude',
        'longitude',
        'lat_long',
        'obs',
        'cemiterio',
        'cemiterio_id',
        'funeraria_id',
        'user_id',         
        'causa_id',         
        'taxa_id',        
    ];
    
    public function clientes()
    {
        return $this->hasOne(Cliente::class);
    }
    
    public function cemiterios()
    {
        return $this->hasOne(Cemiterio::class);
    }
    
    public function funerarias()
    {
        return $this->hasOne(Funeraria::class);
    }
    
    public function causas()
    {
        return $this->belongsTo(Causa::class);
    }
    
    public function taxas()
    {
        return $this->belongsTo(Taxa::class);
    }
}
