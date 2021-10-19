<?php

namespace App\Http\Livewire\Reservas;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Carbon; 
use App\Traits\GenericTrait;

use App\Models\Cliente;
use App\Models\Reserva;
use App\Models\Taxa;

class ReservasController extends Component
{
    use WithPagination;
    use GenericTrait;

    public $cpf, $data_cadastro, $nomeCliente, $cep, $logradouro, $complemento;
    public $nro, $bairro, $localidade, $uf, $telefone, $celular1, $celular2, $user_id;
    public $selected_id, $selected_cpf, $search, $action = 1 ;
    
    public $cpf_cliente, $nomePessoa, $quadra, $numero, $processo;
    public $tipo='Escolha', $taxa_id, $valor_taxa;    
    public $obs, $taxas;
    private $pagination = 5;

    public function render()
    {
        $this->clientes = Cliente::all();
        $this->reserva = Reserva::get();
        $this->taxas = Taxa::get();
        $this->user_id = auth()->user()->id;

        if(strlen($this->search) > 0){
            
            $info = Reserva::where('nome', 'like', '%'.$this->search.'%')
                ->orWhere('cpf_cliente', 'like', $this->search.'%')
                ->orWhere('reservas.numero', $this->search)
                ->paginate($this->pagination);                
        }
        else {
            $info = Reserva::orderBy('reservas.id', 'desc')
                    ->paginate($this->pagination);
            
        }
        
        foreach ($info as $v) {
            $v->cpf_cliente = $this->CpfCli($v->cpf_cliente);
            $v->cep = $this->cep($v->cep);
            $v->telefone = $this->fone($v->telefone);
            $v->celular1 = $this->fone($v->celular1);
            $v->celular2 = $this->fone($v->celular2);
            
        }

        return view('livewire.reservas.reservas-controller', [
            'info' => $info
        ]);
    }

    
    public function buscaCPF()
    {
        if(strlen($this->cpf) <= 0) return;

        $this->cpf_cliente = preg_replace('/[^0-9]/', '', $this->cpf_cliente);

        $rules = ['cpf_cliente' => 'required'];

        $customMessages = ['cpf_cliente.required' => 'O CPF é obrigatório!'];

        $this->validate($rules, $customMessages);

        if(!$this->ValidaCpf($this->cpf_cliente)) {
            $this->emit('msg-error', 'CPF / CNPJ é inválido..');;
            return;
        }
        
        $info = Reserva::where('cpf_cliente', $this->cpf_cliente)->first();
        
            if($info){
                if($this->action != 2){
                    $this->selected_cpf = $info->cpf_cliente;  
                    $this->emit('msgok', 'Reserva já existe... Atualizando...');
                    $this->editReserva($this->cpf_cliente);
                }
            }
            else {
                $cpf_cliente = $this->cpf_cliente;
                $this->resetCliente();
                $this->cpf_cliente = $this->CpfCli($cpf_cliente);
            }
        
    }
    

    public function updatingSearch()
    {
        $this->gotoPage(1);
    }

    public function doAction($action)
    {
        $this->action = $action;
    }

    function resetCliente() 
    {
        
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

        $this->cpf_cliente = '';
        
        $this->quadra = '';
        $this->numero = '';
        $this->valor_taxa = 0.00;
        $this->tipo = 'Escolha';
        $this->taxa_id = 'Escolha';        
        $this->processo = '';
        
        $this->obs ='';
        $this->selected_id = null;
        $this->selected_cpf = null;
        $this->action = 1;
        $this->search = '';
    }

    public function editCliente($cpf)
    {
        $cliente = Cliente::where('cpf', $cpf)->first();
        if($cliente){
            $this->selected_cpf     = $cpf;

            $this->cpf_cliente      = $this->CpfCli($cliente->cpf);
            
            $this->data_cadastro    = $cliente->data_cadastro;
            $this->nomeCliente      = $cliente->nome;
            $this->cep              = $this->cep($cliente->cep);
            $this->logradouro       = $cliente->endereco;
            $this->nro              = $cliente->nro;
            $this->complemento      = $cliente->complemento;
            $this->bairro           = $cliente->bairro;
            $this->localidade       = $cliente->cidade;
            $this->uf               = $cliente->uf;
            $this->telefone         = $this->fone($cliente->telefone);
            $this->celular1         = $this->fone($cliente->celular1);
            $this->celular2         = $this->fone($cliente->celular2);
        }
    }

    public function edit($id)
    {
        $record = Reserva::findOrFail($id);

        $this->selected_id = $id;

        $this->cpf_cliente = $record->cpf_cliente;

        if(!$this->cpf)
            if($this->cpf_cliente) $this->editCliente($this->cpf_cliente);

        $this->nomePessoa = $record->nome;
        
        $this->quadra = $record->quadra;
        $this->numero = $record->numero;
        $this->valor_taxa = $record->valor_taxa;
        $this->tipo = $record->tipo;
        
        $this->taxa_id = $record->taxa_id;

        $this->obs = $record->obs;
         

        $this->action = 2;        
    }

    public function StoreOrUpdate()
    {

        $this->validate([
            
            'quadra' => ['required','string','max:4'],
            'numero' => ['required', 'int'],
            'tipo' => 'Required|not_in:Escolha',
            
            'cpf_cliente' => 'required|max:14',
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
                'cpf' => $this->cpf_cliente,
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

        
        $this->cpf_cliente = preg_replace('/[^0-9]/', '', $this->cpf_cliente);

        if($this->selected_id <= 0)
        {
            $record = Reserva::create([
            'nome' => $this->nomeCliente,        
            'cpf_cliente' => $this->cpf_cliente,
            
            'quadra' => $this->converteMaiusculo($this->quadra),
            'numero' => $this->numero,
            'tipo' => $this->tipo,
            'valor_taxa' => $this->valor_taxa,
            
            'obs' => $this->converteMaiusculo($this->obs),
                           
            'taxa_id' => $this->taxa_id,

            'user_id' => $this->user_id,
            ]);
        }
        else{
            $record = Reserva::find($this->selected_id);
            
            $record->update([
            'nome' => $this->nomeCliente,         
            'cpf_cliente' => $this->cpf_cliente,
            
            'quadra' => strtoupper($this->quadra),
            'numero' => $this->numero,
            'tipo' => $this->tipo,
            'valor_taxa' => $this->valor_taxa,            
            'obs' => $this->converteMaiusculo($this->obs),
                                       
            'taxa_id' => $this->taxa_id,
            'user_id' => $this->user_id,
            ]);
        }

        
        if($this->selected_cpf)        
            $this->emit('msgok', 'Cliente atualizada com exito');
        else 
            $this->emit('msgok', 'Cliente criado com exito');
        

        if($this->selected_id)        
            $this->emit('msgok', 'Reserva atualizada com exito');
        else 
            $this->emit('msgok', 'Sepultura reservada com exito');
        
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

        if(strval($this->numero)>0){

            $unumero = Reserva::whereQuadraAndNumero($this->quadra, $this->numero)
                    ->orderBy('id', 'desc')->first();

            if(! $unumero) return;
       
        }        
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
        $tel = 'Telefone(s): '.$this->fone($this->telefone).' '.$this->fone($this->celular1).' '.$this->fone($this->celular2);
        
        $obs = 'TAXA (R$'.number_format($tx->valor,2).') REFERENTE A '.$tx->tipo;
        $obs = $obs.chr(13).chr(13).$end.chr(13).chr(13).$bai.chr(13).chr(13).$tel;
                
        return $this->obs = $obs;
        
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
    
    
    public function Cpf() {
        
        if (!$this->cpf) {
     
            return '';
     
        }

        if(strlen($this->cpf) < 11) return;

        if(!$this->ValidaCpf($this->cpf)) {
            $this->emit('msg-error', 'CPF / CNPJ é inválido..');;
            return;
        }

        
        $this->cpf_cliente = $this->cpf;
        
        $this->cpf = $this->CpfCli($this->cpf); 
               
     
     }

     public function destroy($id)
     {
         if($id) {
             
             $record = Reserva::where('id', $id);
             $record->delete();
             $this->resetInput();
             $this->emit('msgok','Reserva eliminada com exito');
         }
     }
 
     protected $listeners = [
         'deleteRow' => 'destroy',
     ];
 

}
