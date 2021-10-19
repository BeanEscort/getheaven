<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Multitenancy\Models\Tenant;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Tenant::checkCurrent()
           ? $this->runTenantSpecificSeeders()
           : $this->runLandlordSpecificSeeders();

    }

    public function runTenantSpecificSeeders()
    {
        \App\Models\User::factory(1)->create();
        $this->call([

            StatesTableSeeder::class,
            CitiesTableSeeder::class,
            Tipo_sepulturasSeeder::class,
            PermissionsTableSeeder::class,
        ]);
    }

    public function runLandlordSpecificSeeders()
    {
        $this->call([

            StatesTableSeeder::class,
            CitiesTableSeeder::class,
        ]);
    }
}
