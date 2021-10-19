<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRotasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rotas', function (Blueprint $table) {
            $table->id();
        $table->unsignedBigInteger('cemiterio_id');
            $table->string('quadra', 10);
            $table->string('bloco', 10)->nullable();
            $table->string('latitude', 15);
            $table->string('longitude', 15);
            $table->foreign('cemiterio_id')->references('id')->on('cemiterios');
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
        Schema::dropIfExists('rotas');
    }
}
