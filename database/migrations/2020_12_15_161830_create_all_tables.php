<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAllTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('causas', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 80);
            $table->timestamps();
        });

        Schema::create('cemiterios', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->timestamps();
        });

        Schema::create('tipo_sepulturas', function (Blueprint $table) {
            $table->id();
            $table->string('tipo');
            $table->timestamps();
        });

        Schema::create('funerarias', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->timestamps();
        });

        Schema::create('ufirs', function (Blueprint $table) {
            $table->id();
            $table->integer('ano');
            $table->decimal('valor_ufir', 10, 2)->default(0);
            $table->decimal('valor_anterior', 10, 2)->default(0);
            $table->timestamps();
        });

        Schema::create('taxas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ufir_id');
            $table->string('tipo', 50);
            $table->decimal('valor', 10, 2)->default(0);
            $table->decimal('total_ufir', 10, 2)->default(0);
            $table->foreign('ufir_id')->references('id')->on('ufirs');
            $table->timestamps();
        });

        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->date('data_cadastro');
            $table->string('cpf')->unique();
            $table->string('cep')->nullable();
            $table->string('endereco')->nullable();
            $table->string('nro')->nullable();            
            $table->string('complemento')->nullable();
            $table->string('bairro')->nullable();
            $table->string('cidade')->nullable();
            $table->string('uf')->nullable();
            $table->string('telefone')->nullable(); 
            $table->string('celular1')->nullable();
            $table->string('celular2')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
        });

        Schema::create('pessoas', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->unsignedBigInteger('cliente_id');
            $table->string('pai')->nullable();
            $table->string('mae')->nullable();
            $table->string('idade')->nullable();
            $table->string('quadra')->nullable();
            $table->integer('numero')->nullable();
            
            $table->string('processo')->nullable(); 
            
            $table->decimal('valor_taxa', 10, 2)->default(0); 
            $table->enum('pago', ['S', 'N'])->default('N');
            $table->enum('cor', ['BRANCA','PRETA', 'PARDA', 'MORENA', 'MULATA', 'AMARELA', 'INDÍGENA'])->nullable();
            $table->enum('sexo', ['MASCULINO','FEMININO'])->nullable();
            
            $table->date('dt_obito');
            $table->date('dt_sepultamento');
            $table->time('hora_sepultamento')->nullable();
            
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->text('obs')->nullable();

            $table->unsignedBigInteger('tipo_id');
            $table->unsignedBigInteger('cemiterio_id');
            $table->unsignedBigInteger('funeraria_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('causa_id')->default(1);
            $table->unsignedBigInteger('taxa_id');
            
            $table->foreign('tipo_id')->references('id')->on('tipo_sepulturas');
            $table->foreign('cliente_id')->references('id')->on('clientes');
            $table->foreign('cemiterio_id')->references('id')->on('cemiterios');
            $table->foreign('funeraria_id')->references('id')->on('funerarias');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('causa_id')->references('id')->on('causas');
            $table->foreign('taxa_id')->references('id')->on('taxas');
            $table->timestamps();
        });

	Schema::create('reservas', function (Blueprint $table) {
            $table->id();
            $table->string('cpf_cliente');
            $table->date('data_cadastro')->nullable();
            $table->text('obs')->nullable();
            $table->text('obs1')->nullable();
            $table->text('obs2')->nullable();
            $table->string('quadra');
            $table->integer('numero');
            $table->string('processo')->nullable();
            $table->string('carneiro')->nullable();
            $table->string('galeria')->nullable();
            $table->enum('tipo',['CARNEIRO','GALERIA'])->default('CARNEIRO');            
            $table->unsignedBigInteger('user_id')->nullable();

            $table->foreign('cpf_cliente')->references('cpf')->on('clientes');
            $table->foreign('user_id')->references('id')->on('users');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('causas');
        Schema::dropIfExists('cemiterios');
        Schema::dropIfExists('tipo_sepulturas');
        Schema::dropIfExists('funerarias');
        Schema::dropIfExists('ufirs');
        Schema::dropIfExists('taxas');
        Schema::dropIfExists('clientes');
        Schema::dropIfExists('pessoas');
	Schema::dropIfExists('reservas');
    }

}
