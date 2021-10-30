<?php

namespace App\Console\Commands\Tenant;

use App\Models\Company;
use App\Tenant\ManagerTenant;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class TenantMigrations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tenants:migrate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run Migrations Tenants';

    private $tenant;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(ManagerTenant $tenant)
    {
        parent::__construct();

        $this->tenant = $tenant;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $companies = Company::all();

        foreach ($companies as $company) {
            $this->tenant->setConnection($company);

            if($company->name != 'Admin'){
                $this->info("Connecting Company {$company->name}");

                Artisan::call('migrate', [
                    ' --force' => true,
                    ' --path' => '/database/migrations',
                    ' --database=tenant'
                ]);

                $this->info("End Connecting Company {$company->name}");
                $this->info("--------------------------------------------");
            }
        }
    }

    
}
