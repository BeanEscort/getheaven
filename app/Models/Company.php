<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Spatie\Multitenancy\Models\Tenant;

class Company extends Tenant
{
    protected $table = 'tenants';
    protected $fillable = [
        'name',
        'domain',
        'database',
        'cnpj',
	'endereco',
	'numero',
	'bairro',
        'contato',
        'telefone_fixo',
        'celular',
        'cidade',
        'uf',
        'city_id',
        'state_id',
        'orgao_responsavel',
	'logo',
    ];

    public static function boot(){
        parent::boot();

        /* self::creating(function ($model) {
            $model->uuid = (string) Str::uuid(4);
        }); */

    }

    public static function booted()
    {
        self::creating(function($model) {

            $model->createDatabase($model->database);
        });
    }

    public function createDatabase($database)
    {
        DB::statement("
            CREATE DATABASE IF NOT EXISTS {$database} CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
        ");
    }

    public static function deleteDatabase($database)
    {
        DB::statement("
            DROP DATABASE {$database}
        ");
    }
}

