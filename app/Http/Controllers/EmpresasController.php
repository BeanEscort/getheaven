<?php

namespace App\Http\Controllers;

use App\Console\Commands\Tenant\TenantMigrations;
use App\Events\Tenant\CompanyCreated;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Spatie\Multitenancy\Commands\TenantsArtisanCommand;
use Spatie\Multitenancy\Models\Tenant;

class EmpresasController extends Controller
{
    private $company;

    public function __construct(Company $company)
    {
        $this->company = $company;
        
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies = $this->company->latest()->paginate();

        return view('companies.index', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('companies.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $company = $this->company->create($request->all());

        echo('Criando Tabelas... Aguarde!');

        Artisan::call("tenants:artisan 'migrate:fresh' --tenant=$company->id");

        echo('Migrando os dados do usuário... Aguarde!');

        Artisan::call("tenants:artisan 'db:seed' --tenant=$company->id");
 
       
        return redirect()
                ->route('empresas.index')
                ->withSuccess('Cadastro realizado com sucesso!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($domain)
    {
        $company = $this->company->where('domain', $domain)->first();

        if (!$company)
            return redirect()->back();

        return view('companies.show', compact('company'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($domain)
    {
        $company = $this->company->where('domain', $domain)->first();

        if (!$company)
            return redirect()->back();

        return view('companies.edit', compact('company'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (!$company = $this->company->find($id))
            return redirect()->back()->withInput();

        $company->update($request->all());

        return redirect()
                    ->route('empresas.index')
                    ->withSuccess('Atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!$company = $this->company->find($id))
            return redirect()->back();

        $company->delete();

        return redirect()
                    ->route('empresas.index')
                    ->withSuccess('Deletado com sucesso!');
    }

   
}

