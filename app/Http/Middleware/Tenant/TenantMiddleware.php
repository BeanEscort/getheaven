<?php

namespace App\Http\Middleware\Tenant;

use App\Models\Company;
use App\Tenant\ManagerTenant;
use Closure;
use Illuminate\Http\Request;
use Spatie\Multitenancy\Models\Tenant;

class TenantMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $company =[];

        if(Tenant::current())

            $company = $this->getCompany($request->getHost());
        else if($request->url() != route('apresentacao'))
            return redirect()->route('apresentacao');
        //if($company->database === 'tenancy') return $next($request);

        if(! $company && $request->url() != route('apresentacao')){
            return redirect()->route('apresentacao');
        } else if($request->url() != route('apresentacao')){
            app(ManagerTenant::class)->setConnection($company);
        }

        return $next($request);
    }

    public function getCompany($host)
    {        
        $comp = Company::where('domain', $host)->first();

        if(!$comp) return redirect()->route('apresentacao'); 
        else  
        return $comp;
        
    }
}
