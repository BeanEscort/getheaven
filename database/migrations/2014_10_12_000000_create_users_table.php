<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->foreignId('current_team_id')->nullable();
            $table->text('profile_photo_path')->nullable();
            $table->string('domain')->nullable();
            $table->string('orgao')->nullable();
            $table->enum('tipo', ['Admin', 'Usuário', 'Gerente'])->default('Admin');
	    $table->text('logo')->nullable();
            $table->timestamps();
        });
	Schema::create('empresas', function(Blueprint $table) {
		$table->id();
		$table->string('domain')->nullable();
		$table->string('orgao')->nullable();
		$table->text('logo')->nullable();
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
        Schema::dropIfExists('users');
    }
}
