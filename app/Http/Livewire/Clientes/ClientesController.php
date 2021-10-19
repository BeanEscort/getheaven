<?php

namespace App\Http\Livewire\Clientes;

use Illuminate\Support\Carbon;
use Livewire\Component;
use Livewire\WithPagination;
use App\Traits\GenericTrait;

use \App\Models\Cliente;

class ClientesController extends Component
{
    use WithPagination;
    use GenericTrait;

    public $cpf, $data_cadastro, $nome, $clientes, $cep, $logradouro, $complemento;
    public $nro, $bairro, $localidade, $uf, $telefone, $celular1, $celular2, $user_id;
    public $selected_id, $search, $action = 1;
    private $pagination = 5;

    public function render()
    {
        if(strlen($this->search) > 0){

            $info = Cliente::where('nome', 'like', '%'.$this->search.'%')
                ->orWhere('cpf', 'like', $this->search.'%')
                ->paginate($this->pagination);
        }
        else {
            $info = Cliente::orderBy('id', 'desc')
                    ->paginate($this->pagination);

        }

        foreach ($info as $v) {

            $v->cpf = $this->CpfCli($v->cpf);

            $v->data_cadastro = Carbon::parse($this->data_cadastro)->format('d/m/Y');
            $v->cep = $this->cep($v->cep);
            $v->telefone = $this->fone($v->telefone);
            $v->celular1 = $this->fone($v->celular1);
            $v->celular2 = $this->fone($v->celular2);

        }

        return view('livewire.clientes.clientes-controller', [
            'info' => $info
        ]);
    }

    public function buscaCPF()
    {
        $this->cpf = preg_replace('/[^0-9]/', '', $this->cpf);

        if(!$this->ValidaCpf($this->cpf)) {
            $this->emit('msg-error', 'CPF / CNPJ é inválido..');;
            return;
        }

        $rules = ['cpf' => 'required'];

        $customMessages = ['cpf.required' => 'Digite o CPF'];

        $this->validate($rules, $customMessages);

        $cliente = Cliente::where('cpf', $this->cpf)->first();

            if($cliente){

                $this->selected_id = $cliente->id;
                $this->edit($this->selected_id);
                $this->emit('msgok', 'Cliente já existe... Atualizando...');
            }
            else {

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

    public function resetInput()
    {
        $this->cpf = '';
        $this->data_cadastro = null;
        $this->nome = '';
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
        $this->selected_id = null;
        $this->action = 1;
        $this->search = '';
    }


    public function edit($id)
    {
        $record = Cliente::find($id);

        $this->selected_id      = $id;
        $this->cpf              = $this->CpfCli($record->cpf);

        $this->data_cadastro    = $record->data_cadastro;
        $this->nome             = $record->nome;
        $this->cep              = $this->cep($record->cep);
        $this->logradouro       = $record->endereco;
        $this->nro              = $record->nro;
        $this->complemento      = $record->complemento;
        $this->bairro           = $record->bairro;
        $this->localidade       = $record->cidade;
        $this->uf               = $record->uf;
        $this->telefone         = $this->fone($record->telefone);
        $this->celular1         = $this->fone($record->celular1);
        $this->celular2         = $this->fone($record->celular2);
        $this->user_id          = auth()->user()->id;
        $this->action = 2;
    }

    public function StoreOrUpdate()
    {
        $this->retiraTracos();
        //$this->buscaCep();
        $this->validate([
            'cpf'           => 'required|max:14',
            'data_cadastro' => 'required',
            'nome'          => 'required',
            'logradouro'    => 'required',
            'nro'           => 'required',
            'bairro'        => 'required',
            'localidade'    => 'required',
            'uf'            => 'required',
            'celular1'      => "required_if:(telefone,'')",
            'telefone'      => "required_if:(celular1,'')",
        ]);

        if($this->selected_id <= 0)
        {

            $record = Cliente::create([
                'cpf'           => $this->cpf,
                'data_cadastro' => $this->data_cadastro,
                'nome'          => $this->nome,
                'cep'           => $this->cep,
                'endereco'      => $this->logradouro,
                'nro'           => $this->nro,
                'complemento'   => $this->complemento,
                'bairro'        => $this->bairro,
                'cidade'        => $this->localidade,
                'uf'            => $this->uf,
                'telefone'      => $this->telefone,
                'celular1'      => $this->celular1,
                'celular2'      => $this->celular2,
                'user_id'       => $this->user_id,
            ]);
        }
        else{
            $record = Cliente::find($this->selected_id);

            $record->update([
                'data_cadastro' => $this->data_cadastro,
                'nome'          => $this->nome,
                'cep'           => $this->cep,
                'endereco'      => $this->logradouro,
                'nro'           => $this->nro,
                'complemento'   => $this->complemento,
                'bairro'        => $this->bairro,
                'cidade'        => $this->localidade,
                'uf'            => $this->uf,
                'telefone'      => $this->telefone,
                'celular1'      => $this->celular1,
                'celular2'      => $this->celular2,
                'user_id'       => $this->user_id,
            ]);
        }

        if($this->selected_id)
            $this->emit('msgok', 'Cliente atualizado com exito');
        else
            $this->emit('msgok', 'Cliente criado com exito');

        $this->resetInput();
    }

    public function destroy($id)
    {
        if($id) {
            $record = Cliente::where('id', $id);
            $record->delete();
            $this->resetInput();
            $this->emit('msgok','Registro eliminado com exito');
        }
    }

    protected $listeners = [
        'deleteRow' => 'destroy',
        'doCheckCep' => 'buscaCep'
    ];

    public function nomeUpper()
    {
        $this->nome = strtoupper($this->nome);
    }

    public function enderecoUpper()
    {
        $this->logradouro = strtoupper($this->logradouro);

    }

    public function bairroUpper()
    {
        $this->bairro = strtoupper($this->bairro);
    }

    public function cidadeUpper()
    {
        $this->localidade = strtoupper($this->localidade);
    }

    public function ufUpper()
    {
        $this->uf = strtoupper($this->uf);
    }

}
