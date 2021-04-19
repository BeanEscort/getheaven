<?php 

namespace App\Tenant;

use App\Models\Company;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ManagerTenant
{
    public function setConnection(Company $company)
    {
        DB::purge('tenant');

        //config()->set('database.connections.tenant.host', $company->domain);
        config()->set('database.connections.tenant.database', $company->database);

        DB::reconnect('tenant');

        Schema::connection('tenant')->getConnection()->reconnect();
    }
}
