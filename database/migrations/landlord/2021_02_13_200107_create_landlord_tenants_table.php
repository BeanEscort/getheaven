<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLandlordTenantsTable extends Migration
{
    public function up()
    {
        Schema::create('tenants', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('domain')->unique();
            $table->string('database')->unique();
	    $table->string('cnpj')->nullable();
	    $table->string('telefone_fixo')->nullable();
	    $table->string('celular')->nullable();
    	    $table->foreignId('city_id')->nullable();
	    $table->foreignId('state_id')->nullable();
	    $table->string('orgao_responsavel')->nullable();
            $table->timestamps();
        });
    }
}
