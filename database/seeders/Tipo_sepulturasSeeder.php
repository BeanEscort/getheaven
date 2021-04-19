<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Tipo_sepulturasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tipo_sepulturas')->insert([
            ['id' => 1, 'tipo' => 'CARNEIRO'],
            ['id' => 2, 'tipo' => 'GALERIA'],
            ['id' => 3, 'tipo' => 'COLUMBARIO'],
            ['id' => 4, 'tipo' => 'COVA RASA'],
            
        ]);
    }
}
