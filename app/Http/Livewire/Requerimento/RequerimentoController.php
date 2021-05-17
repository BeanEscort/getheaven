<?php

namespace App\Http\Livewire\Requerimento;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;
use App\Traits\GenericTrait;

use \App\Models\Rota;
use \App\Models\Cliente;
use \App\Models\Pessoa;
use \App\Models\Funeraria;
use \App\Models\Cemiterio;
use \App\Models\Taxa;
use \App\Models\Tipo;
use App\Models\Ufir;

class RequerimentoController extends Component
{
    use WithPagination;
	use GenericTrait;

    public $cpf, $data_cadastro, $nomeCliente, $cep, $logradouro, $complemento;
    public $nro, $bairro, $localidade, $uf, $telefone, $celular1, $celular2, $user_id;
    public $selected_id, $selected_cpf, $search, $action = 1, $cpf_cliente ;

    public $cnome = null, $tnome = null, $fnome = null,$nomePessoa, $cliente_id=null, $mae, $idade, $quadra, $numero;
    public $tp_sepultura='Escolha', $taxa_id='Escolha', $valor_taxa, $total_ufir, $ufir, $ufir_id;
    public $dt_obito, $dt_sepultamento, $tipo, $tipotaxa, $hora_sepultamento, $latitude;
    public $longitude, $obs, $cemiterio_id='Escolha', $funeraria_id='Escolha';
    public $cemiterios, $funerarias, $tipos, $taxas, $modalFormVisible = false;
    private $pagination = 5;
    public $modalFunerariaVisible = false;
    public $modalTipoVisible = false;
    public $modalTaxaVisible = false;

    public function mount()
    {
        $ufir = Ufir::where('ano', date_format(now(),'Y'))->first();
        if($ufir){
            $this->ufir = $ufir->valor_ufir;
            $this->ufir_id = $ufir->id;
        } else {
            $this->ufir = 0.00;
        }

    }


    public function render()
    {
        $this->clientes = Cliente::get();
/*	 $qtd = $this->clientes->count();
	for ($i = 1; $i<$qtd ; $i++) {
    		$cpf = $this->clientes[$i]['cpf'];
            $end = $this->clientes[$i]['endereco'].', '.$this->clientes[$i]['nro'];

            $bai = 'Bairro: '.$this->clientes[$i]['bairro'].' - '.$this->clientes[$i]['cidade'].'-'.$this->clientes[$i]['uf'];
            $tel = 'Telefone(s): '.$this->clientes[$i]['telefone'].' '.$this->clientes[$i]['celular1'].' '.$this->clientes[$i]['celular2'];

	    $pessoa = Pessoa::where('cpf_cliente','=',$cpf)->first();
	if($pessoa){
		$obs = $pessoa->obs;
		if(!$obs){ 
			$txid = $pessoa->taxa_id;
			$tx = 0;
			if(intval($txid>0))
            			$tx = TAXA::find($txid);

			if($tx){
            			$obs = 'TAXA (R$'.number_format($tx->valor,2).') REFERENTE A '.$tx->tipo;
            			$obs = $obs.'<br>'.$end.'<br>'.$bai.'<br>'.$tel;
			}
		}
	        $pessoa->update([
            	    'cliente_id' => $this->clientes[$i]['id'],
                    'obs' => $obs            
            	]);
        }

	}
*/
        $this->cemiterios = Cemiterio::get();
        $this->funerarias = Funeraria::get();
        $this->taxas = Taxa::get();
        $this->tipos = Tipo::get();
        if(auth()->user())
        $this->user_id = auth()->user()->id;

        if(strlen($this->search) > 1){
            if(intval($this->search) > 0){
                $info = Pessoa::where('numero', $this->search)->orderBy('dt_obito', 'desc')
                ->paginate($this->pagination);
            } else {
                $info = Pessoa::where('nome', 'like', '%'.$this->search.'%')
                    ->orWhere('mae', 'like', '%'.$this->search.'%')
		    ->orderBy('dt_obito', 'desc')
                    ->paginate($this->pagination);
            }
        }
        else {
            $info = Pessoa::orderBy('dt_obito', 'desc')
                    ->paginate($this->pagination);

        }

        return view('livewire.requerimento.requerimento-controller', [
            'info' => $info
        ]);
    }


    public function createCemiterio()
    {
        if($this->cnome==null){
            session()->flash('danger', 'Nome do cemitério é obrigatório');
            return;
        }

        if(Cemiterio::where('nome', $this->cnome)->count() > 0){
            session()->flash('danger', 'Cemitério já cadastrado');
            $this->cnome = null;
            return;
        }

        Cemiterio::create($this->modelData($this->cnome));
        $this->cemiterios = Cemiterio::get();

        $this->modalFormVisible = false;
        session()->flash('message', 'Registro criado com exito');
        $this->cnome = null;
    }

    public function createTaxa()
    {

        if($this->tipotaxa===null){
            session()->flash('danger', 'Descrição da taxa é obrigatório');
            return;
        }

        if(Taxa::where('tipo', $this->tipotaxa)->count() > 0){
            session()->flash('danger', 'Esse tipo de taxa já está cadastrado');
            $this->tipotaxa = null;
            return;
        }

        $this->validate([
            'tipotaxa' => 'required',
            'valor_taxa' => 'required',
            'total_ufir' => 'required',
        ]);

        Taxa::create([
            'tipo' => $this->converteMaiusculo($this->tipotaxa),
            'valor' => $this->valor_taxa,
            'total_ufir' => $this->total_ufir,
            'ufir_id' => $this->ufir_id,
        ]);
        $this->taxas = Taxa::get();

        $this->resetTaxa();
        session()->flash('message', 'Registro criado com exito');
    }

    public function resetTaxa()
    {
        $this->tipotaxa = null;
        $this->valor_taxa = null;
        $this->total_ufir = null;
    }

    public function updateValor()
    {
        $this->valor_taxa = number_format($this->total_ufir * $this->ufir, 2);
    }


    public function createFuneraria()
    {
        if($this->fnome==null){
            session()->flash('danger', 'Nome da funerária é obrigatório.');
            return;
        }

        if(Funeraria::where('nome', $this->fnome)->count() > 0){
            session()->flash('danger', 'Funerária já cadastrada');
            $this->fnome = null;
            return;
        }

        Funeraria::create($this->modelData($this->fnome));

        $this->funerarias = Funeraria::get();
        $this->fnome = null;
        session()->flash('message', 'Registro criado com exito');

    }

    public function createTipo()
    {
        $this->tipo = $this->converteMaiusculo($this->tipo);
        if($this->tipo ==''){
            session()->flash('danger', 'Tipo de Sepultura é obrigatório');
            return;
        }

        if(Tipo::where('tipo', $this->tipo)->count() > 0) {
            session()->flash('danger', 'Tipo de Sepultura já cadastrado!');
            $this->tipo = null;
            return;
        }

        Tipo::create( ['tipo' => $this->tipo]);
        $this->tipos = Tipo::get();
        session()->flash('message', 'Registro criado com exito');
        $this->tipo = null;
    }

    public function modelData($campo)
    {
        return [
            'nome' => $this->converteMaiusculo($campo),
        ];
    }

    public function createShowModal($q)
    {
        if ($q === 1) {
            $this->modalFormVisible = true;
        } else if ($q === 2){
            $this->modalFunerariaVisible = true;
        } else if ($q === 3){
            $this->modalTipoVisible = true;
        } else if ($q === 4){
            $this->modalTaxaVisible = true;
        }

    }

    public function buscaCPF()
    {
        if(strlen($this->cpf) <=0) return;

        if($this->selected_cpf) return;

        $this->cpf = preg_replace('/[^0-9]/', '', $this->cpf);

        $rules = ['cpf' => 'required'];

        $customMessages = ['cpf.required' => 'O CPF é obrigatório!'];

        $this->validate($rules, $customMessages);

        if(!$this->ValidaCpf($this->cpf)) {
            $this->emit('msg-error', 'CPF / CNPJ é inválido..');
            $this->cpf = '';
            return back();
        }

        $info = Cliente::where('cpf', $this->cpf)->first();

            if($info){

                    $this->selected_cpf = $info->cpf;
                    $this->emit('msgok', 'Cliente já existe... Atualizando...');
                    $this->editCliente($info->id);

            }
            else {
                $cpf = $this->cpf;
                $this->resetCliente();
                $this->cpf = $this->CpfCli($cpf);
            }

    }


    public function updatingSearch()
    {
        $this->gotoPage(1);
    }

    public function doAction($action)
    {
        $this->resetInput();
        $this->action = $action;

    }

    function resetCliente()
    {
        $this->cpf = '';
        $this->data_cadastro = null;
        $this->nomeCliente = '';
        $this->cep = '';
        $this->logradouro = '';
        $this->nro = '';
        $this->complemento = '';
        $this->bairro = '';
        $this->localidade = '';
        $this->uf = '';
        $this->telefone = '';
        $this->celular1 = '';
        $this->celular2 = '';

    }

    public function resetInput()
    {
        $this->resetCliente();

        $this->cliente_id = null;
	$this->cpf_cliente = null;
        $this->nomePessoa = '';
        $this->mae = '';
        $this->idade = '';
        $this->quadra = '';
        $this->numero = null;
        $this->valor_taxa = 0.00;
        $this->tp_sepultura = 'Escolha';
        $this->cemiterio_id = 'Escolha';
        $this->funeraria_id = 'Escolha';
        $this->taxa_id = 'Escolha';

        $this->latitude ='';
        $this->longitude ='';
        $this->obs ='';
        $this->dt_obito = null;
        $this->dt_sepultamento = null;
        $this->hora_sepultamento = null;

        $this->selected_id = null;
        $this->selected_cpf = null;
        $this->action = 1;
        $this->search = '';
    }

    public function editCliente($id)
    {
        $cliente = Cliente::where('id', $id)->first();
        if($cliente){
            $this->selected_cpf     = $cliente->cpf;

            $this->cpf              = $cliente->cpf;

            $this->data_cadastro    = $cliente->data_cadastro;
            $this->nomeCliente      = $cliente->nome;
            $this->cep              = $cliente->cep;
            $this->logradouro       = $cliente->endereco;
            $this->nro              = $cliente->nro;
            $this->complemento      = $cliente->complemento;
            $this->bairro           = $cliente->bairro;
            $this->localidade       = $cliente->cidade;
            $this->uf               = $cliente->uf;
            $this->telefone         = $cliente->telefone;
            $this->celular1         = $cliente->celular1;
            $this->celular2         = $cliente->celular2;
        }
    }

    public function edit($id)
    {
        $record = Pessoa::findOrFail($id);

        $this->selected_id = $id;
	$this->cpf_cliente = $record->cpf_cliente;

	if($record->cliente_id)
        	$this->cliente_id = $record->cliente_id;
	else if($record->cpf_cliente)
	{
	 	$cliente = Cliente::where('cpf', $record->cpf_cliente)->first();
//dd($cliente->id);
		$this->cliente_id = $cliente->id;
	}

        if($this->cliente_id) $this->editCliente($this->cliente_id);

        $this->nomePessoa = $record->nome;
        $this->mae = $record->mae;
        $this->idade = $record->idade;
        $this->quadra = $record->quadra;
        $this->numero = $record->numero;
        $this->valor_taxa = $record->valor_taxa;
        $this->tp_sepultura = $record->tipo_id;
        $this->cemiterio_id = $record->cemiterio_id;
        $this->funeraria_id = $record->funeraria_id;
        $this->taxa_id = $record->taxa_id;
        $this->valor_pago = $record->valor_pago;


        $this->latitude = $record->latitude;
        $this->longitude = $record->longitude;
	if($record->obs)
        	$this->obs = $record->obs;
	else
		$this->preencheObs();

        $this->dt_obito = date_format($record->dt_obito,'Y-m-d');
        $this->dt_sepultamento = date_format($record->dt_sepultamento,'Y-m-d');
        $this->hora_sepultamento = $record->hora_sepultamento;

        $this->action = 2;
    }

    public function StoreOrUpdate()
    {

        $this->validate([
            'dt_obito' => ['required', 'before_or_equal:dt_sepultamento'],
            'dt_sepultamento' => ['required', 'after_or_equal:dt_obito'],
            'nomePessoa' => 'required',
            'quadra' => ['required','string','max:4'],
            'numero' => ['required', 'int'],
            'tp_sepultura' => 'Required|not_in:Escolha',
            'cemiterio_id' => 'Required|not_in:Escolha',
            'funeraria_id' => 'Required|not_in:Escolha',
            'taxa_id' => 'Required|not_in:Escolha',

            'cpf' => 'required|max:18',
            'data_cadastro' => 'required',
            'nomeCliente' => 'required',
            'logradouro' => 'required',
            'nro' => 'required',
            'bairro' => 'required',
            'localidade' => 'required',
            'uf' => 'required',
            'celular1' => "required_if:(telefone,'')",
            'telefone' => "required_if:(celular1,'')",
        ]);

        $this->retiraTracos();

        if(strlen($this->selected_cpf) <= 0)
        {

            $record = Cliente::create([
                'cpf' => $this->cpf,
                'data_cadastro' => $this->data_cadastro,
                'nome' => $this->nomeCliente,
                'cep' => $this->cep,
                'endereco' => $this->logradouro,
                'nro' => $this->nro,
                'complemento' => $this->complemento,
                'bairro' => $this->bairro,
                'cidade' => $this->localidade,
                'uf' => $this->uf,
                'telefone' => $this->telefone,
                'celular1' => $this->celular1,
                'celular2' => $this->celular2,
                'user_id' => $this->user_id,
            ]);
        }
        else{
            $record = Cliente::where('cpf', $this->selected_cpf)->first();

            $record->update([
                'data_cadastro' => $this->data_cadastro,
                'nome' => $this->nomeCliente,
                'cep' => $this->cep,
                'endereco' => $this->logradouro,
                'nro' => $this->nro,
                'complemento' => $this->complemento,
                'bairro' => $this->bairro,
                'cidade' => $this->localidade,
                'uf' => $this->uf,
                'telefone' => $this->telefone,
                'celular1' => $this->celular1,
                'celular2' => $this->celular2,
                'user_id' => $this->user_id,
            ]);
        }

        $this->cliente_id = $record->id;
	$this->cpf_cliente = $record->cpf;
        $this->taxas = Taxa::find($this->taxa_id);
        $this->valor_taxa = $this->taxas->valor;
	$this->latlong();
        if($this->selected_id <= 0)
        {
            $record = Pessoa::create([
            'nome' => $this->nomePessoa,
            'cliente_id' => $this->cliente_id,
	    'cpf_cliente' => $this->cpf_cliente,
            'mae' => $this->mae,
            'idade' => $this->idade,
            'quadra' => $this->converteMaiusculo($this->quadra),
            'numero' => $this->numero,
            'tipo_id' => $this->tp_sepultura,
            'valor_taxa' => $this->valor_taxa,
            'dt_obito'  => $this->dt_obito,
            'dt_sepultamento'  => $this->dt_sepultamento,
            'hora_sepultamento' => $this->hora_sepultamento,

            'latitude' => $this->latitude,
            'longitude' => $this->longitude,

            'obs' => $this->converteMaiusculo($this->obs),
            'cemiterio_id' => $this->cemiterio_id,

            'funeraria_id' => $this->funeraria_id,

            'taxa_id' => $this->taxa_id,
            'causa_id' => 1,

            'user_id' => $this->user_id,
            ]);
        }
        else{
            $record = Pessoa::find($this->selected_id);
            if($this->hora_sepultamento == "") $this->hora_sepultamento = null;
	
            $record->update([
            'nome' => $this->nomePessoa,
            'cliente_id' => $this->cliente_id,
	    'cpf_cliente' => $this->cpf_cliente,
            'mae' => $this->mae,
            'idade' => $this->converteMaiusculo($this->idade),
            'quadra' => $this->converteMaiusculo($this->quadra),
            'numero' => $this->numero,
            'tipo_id' => $this->tp_sepultura,
            'valor_taxa' => $this->valor_taxa,
            'dt_obito'  => $this->dt_obito,
            'dt_sepultamento'  => $this->dt_sepultamento,

            'hora_sepultamento' => $this->hora_sepultamento,

            'latitude' => $this->latitude,
            'longitude' => $this->longitude,

            'obs' => $this->obs,
            'cemiterio_id' => $this->cemiterio_id,

            'funeraria_id' => $this->funeraria_id,

            'taxa_id' => $this->taxa_id,

            'user_id' => $this->user_id,
            ]);
        }


        if($this->selected_cpf)
            $this->emit('msgok', 'Requerente atualizado com exito');
        else
            $this->emit('msgok', 'Requerente criado com exito');


        if($this->selected_id)
            $this->emit('msgok', 'Registro do Falecido atualizado com exito');
        else
            $this->emit('msgok', 'Registro do Falecido criado com exito');

        $this->resetInput();
    }


    public function testaQuadra(){
        if(strlen($this->quadra)<=0) {
            $this->emit('msg-error', 'O número da Quadra é obrigatório.');
            $this->validate (['quadra' => 'required']);
            return false;
        }
        return true;
    }

    public function buscaNumero()
    {

        $this->testaQuadra();

        $this->validate(['numero'=>'required']);

        if(intval($this->numero)>0){
            if ($this->selected_id <= 0) {

                $unumero = Pessoa::whereQuadraAndNumero($this->quadra, $this->numero)
                        ->orderBy('dt_obito', 'desc')->first();

                if(! $unumero) return;

                $start  =  Carbon::parse($unumero->dt_obito);

                $end    = new \DateTime(Carbon::now());
                $ano = $start->diffInYears($end);
                $meses = $start->diff($end)->format('%M');
                $dias = $start->diff($end)->format('%d');

                if(strval($ano) < 3){
                    $this->emit('msgok', 'O Último sepultado foi '.$unumero->nome.' em '.date_format($unumero->dt_sepultamento, 'd-m-Y'));
                    $this->emit('msg-error', 'Diferença de sepultamento com '.($ano > 0 ? $ano. 'ano(s) ' : ''). ($meses > 0 ? $meses.' mes(s)':'').($dias > 0 ? $dias.' dia(s)':'').' apenas!');

                }
            }
        }
        return;
    }

    public function telefone(){
        if(strlen($this->telefone)>0)
            $this->telefone = $this->fone($this->telefone);
    }

    public function cel1(){
        if(strlen($this->celular1)>0)
            $this->celular1 = $this->fone($this->celular1);
    }

    public function cel2(){
        if(strlen($this->celular2)>0)
            $this->celular2 = $this->fone($this->celular2);
    }

    public function preencheObs(){
        $tx = TAXA::find($this->taxa_id);
        $end = $this->logradouro.', '.$this->nro;

        $bai = 'Bairro: '.$this->bairro.' - '.$this->localidade.'-'.$this->uf;
        $tel = 'Telefone(s): '.$this->telefone.' '.$this->celular1.' '.$this->celular2;

        $obs = 'TAXA (R$'.number_format($tx->valor,2).') REFERENTE A '.$tx->tipo;
        $obs = $obs.'<br>'.$end.'<br>'.$bai.'<br>'.$tel;

        $this->obs = trim($obs);

    }

    public function latlong(){
	if($this->tp_sepultura=='4') $tp = '1'; else $tp = $this->tp_sepultura;
	$latlong = Rota::where('cemiterio_id', $this->cemiterio_id)
		->where('quadra', $this->quadra)
		->where('bloco',$tp)
		->first();
	if($latlong){
        	$this->latitude = $latlong->latitude;
        	$this->longitude = $latlong->longitude;
        }
    }

    public function nomeUpper()
    {
        $this->nomePessoa = $this->converteMaiusculo($this->nomePessoa);
    }
    public function nomeClienteUpper()
    {
        $this->nomeCliente = $this->converteMaiusculo($this->nomeCliente);
    }

    public function enderecoUpper()
    {
        $this->logradouro = $this->converteMaiusculo($this->logradouro);

    }

    public function bairroUpper()
    {
        $this->bairro = $this->converteMaiusculo($this->bairro);
    }

    public function cidadeUpper()
    {
        $this->localidade = $this->converteMaiusculo($this->localidade);
    }

    public function ufUpper()
    {
        $this->uf = $this->converteMaiusculo($this->uf);
    }
    public function maeUpper()
    {
        $this->mae = $this->converteMaiusculo($this->mae);
    }


    public function Cpf() {

        if (!$this->cpf) {

            return '';

        }

        if(strlen($this->cpf) < 11) return;

        if(!$this->ValidaCpf($this->cpf)) {
            session()->flash('danger', 'CPF / CNPJ é inválido..');
            $this->cpf = '';
            return back();
        }


        $this->cpf = $this->CpfCli($this->cpf);


     }

}
