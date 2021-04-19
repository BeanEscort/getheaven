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
        else if($request->url() != route('404.tenant'))
            return redirect()->route('404.tenant');
        //if($company->database === 'tenancy') return $next($request);

        if(! $company && $request->url() != route('404.tenant')){
            return redirect()->route('404.tenant');
        } else if($request->url() != route('404.tenant')){
            app(ManagerTenant::class)->setConnection($company);
        }

        return $next($request);
    }

    public function getCompany($host)
    {        
        $comp = Company::where('domain', $host)->first();

        if(!$comp) return redirect()->route('404.tenant'); 
        else  
        return $comp;
        
    }
}
