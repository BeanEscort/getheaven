<?php

namespace App\Http\Livewire;

use App\Console\Commands\Tenant\TenantMigrations;
use App\Events\Tenant\CompanyCreated;
use App\Models\City;
use Illuminate\Support\Facades\Artisan;
use Spatie\Multitenancy\Commands\TenantsArtisanCommand;
use Spatie\Multitenancy\Models\Tenant;
use App\Traits\GenericTrait;

use App\Models\Company;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;
use Spatie\Multitenancy\Tasks\SwitchTenantTask;
use Livewire\WithFileUploads;

class Pages extends Component
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
    protected $description = 'Executa as Migrations dos Inquilinos';

    use WithFileUploads;
    use WithPagination;
    use GenericTrait;

    public $modalFormVisible = false;
    public $modalConfirmDeleteVisible = false;
    public $domain, $telefone_fixo, $celular, $logo;
    public $name, $contato, $cities=[], $states, $state_id='Escolha';
    public $cnpj, $orgao_responsavel;
    public $database, $uf, $city_id='Escolha';
    public $modelId, $nome=1, $loadingVisible = false;

    public function changeCity()
    {
        $this->cities = City::where('state_id', $this->state_id)->get();
    }

    public function rules(){
        return [
            'name' => 'required',
            'cnpj' => ['required', 'max:18'],
            'domain' => ['required', Rule::unique('tenants', 'domain')->ignore($this->modelId)],
            'database' => ['required', Rule::unique('tenants', 'database')->ignore($this->modelId)],
            'orgao_responsavel' => 'required',
            'contato' => 'required',
            'city_id' => 'required|not_in:Escolha',
            'state_id' => 'required|not_in:Escolha',
	    'logo' => 'required|image|max:1024',
        ];
    }

    public function mount()
    {

        $this->resetPage();

    }

    public function updatedName($value)
    {   if($this->nome===1)
        $this->generateDomain($value);
    }

    public function testaCNPJ(){
        if(!$this->validaCpf($this->cnpj)){
            $this->cnpj = null;
            session()->flash('erro', 'CNPJ é inválido!');
            return redirect()->back();
        }
        $this->cnpj = $this->CpfCli($this->cnpj);
    }

    public function create()
    {

        $customMessages = [
            'cnpj.required' => 'O CNPJ é obrigatório!',
            'name.required' => 'Nome da Empresa é obrigatório',
            'domain.required' => 'O Domínio é obrigatório',
            'database.required' => 'Banco de Dados deve ser digitado',
            'contato.requried' => 'Digite o nome do Contato',
            'orgao_responsavel.required' => 'Orgão responsável pelo cemitério',
	    'logo.required' => 'É obrigatório escolher uma logo',
	    'logo.image' => 'A logo escolhida é inválida!',
	    'logo.max' => 'A logo deve ter no máximo 1024 caracteres',
        ];

        $this->validate($this->rules(), $customMessages);
        $this->cnpj = $this->CpfCli($this->cnpj);

        $this->loadingVisible = true;
        $this->emit('msgok', 'Criando Banco de Dados!');

        $company = Company::create($this->modelData());
        $city = City::find($company->city_id);

        $this->modalFormVisible = false;

        $this->emit('msgok', 'Migrando as Tabelas!');
	/*Artisan::call('migrate', [
                    ' --path' => '/database/migrations',
                    ' --database' => $company->database
                ]);*/
        Artisan::call("tenants:artisan --tenant=$company->id migrate:fresh");

        Artisan::call("tenants:artisan 'db:seed' --tenant=$company->id");
        $city->name = $this->converteMaiusculo($city->name);
     
        DB::statement("
            update  {$company->database}.users SET domain = '$city->name', orgao = '$company->orgao_responsavel', logo = '$company->logo' WHERE id = '1'

        ");
     
        DB::statement("

            insert into  {$company->database}.causas (nome) VALUE ('INDETERMINADA')
        ");
	DB::statement("

            insert into  {$company->database}.empresas (domain,orgao,logo) VALUE ('$company->domain', '$company->orgao_responsavel','$company->logo')
        ");
        $this->resetVars();
        $this->loadingVisible = false;
        session()->flash('message', 'Empresa '.$company->name.' Criada com sucesso!');

    }

    public function read()
    {
        return Company::where('database', '!=', 'tenancy')->latest()->paginate(3);
    }

    public function update()
    {
       $this->validate();
       $this->loadingVisible = true;
       Company::find($this->modelId)->update($this->modelData());
       $this->loadingVisible = false;
       $this->modalFormVisible = false;
       session()->flash('message', 'Atualizado com sucesso!');
    }

    public function delete()
    {
        $db = Company::find($this->modelId);

        Company::deleteDatabase($db->database);

        Company::destroy($this->modelId);
        $this->modalConfirmDeleteVisible = false;
        $this->resetPage();
        session()->flash('message', 'O Site '.$db->domain.' foi Excluído com sucesso!');
    }

    public function createShowModal()
    {
        $this->resetValidation();
        $this->resetVars();
        $this->modalFormVisible = true;
        $this->nome=1;
    }

    public function updateShowModal($id)
    {
        $this->resetValidation();
        $this->resetVars();
        $this->modelId = $id;
        $this->modalFormVisible = true;
        $this->loadModel();
    }

    public function deleteShowModal($id)
    {
        $this->modelId = $id;
        $this->modalConfirmDeleteVisible = true;
    }

    public function loadModel()
    {
        $data = Company::find($this->modelId);

        $this->cnpj = $data->cnpj;

        $this->domain = $data->domain;
        $this->name = $data->name;

        $this->contato = $data->contato;
        $this->telefone_fixo = $data->telefone_fixo;
        $this->celular = $data->celular;
        $this->database = $data->database;
        $this->orgao_responsavel = $data->orgao_responsavel;
        $this->state_id = $data->state_id;
        $this->changeCity();
        $this->city_id = $data->city_id;
	$this->logo = $data->logo;
    }

    public function modelData()
    {
	$logo = $this->storageLogo();

        return [
            'name' => $this->name,
            'cnpj' => $this->cnpj,
            'domain' => $this->domain,
            'database' => $this->database,
            'contato' => $this->contato,
            'telefone_fixo' => $this->telefone_fixo,
            'celular' => $this->celular,
            'city_id' => $this->city_id,
            'state_id' => $this->state_id,
            'orgao_responsavel' => $this->orgao_responsavel,
	    'logo' => $logo,
        ];
    }

    public function resetVars()
    {
        $this->modelId = null;
        $this->domain = null;
        $this->name = null;
        $this->cnpj = null;
        $this->database = null;
        $this->contato = null;
        $this->telefone_fixo = null;
        $this->celular = null;
        $this->city_id = null;
        $this->state_id = null;
        $this->orgao_responsavel = null;
	$this->logo = null;
    }

    public function generateDomain($value)
    {
        $this->domain = Str::slug($value).'.getheaven.com.br';
        //$this->database = Str::slug($value);
        $this->nome=0;
    }

    public function render()
    {
        $this->states = State::all();

        return view('livewire.pages', [
            'data' => $this->read(),
        ]);
    }

    public function storageLogo()
    {

	$nameFile = Str::slug($this->database).'.'.$this->logo->getClientOriginalExtension();

	return $this->logo->storeAs('tenants', $nameFile);

    }
}
