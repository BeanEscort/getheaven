<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
//use Barryvdh\DomPDF\Facade as PDF;
//use App\Traits\GenericTrait;

use \App\Models\Pessoa;
use \App\Models\Funeraria;
use \App\Models\Cemiterio;
use \App\Models\Causa;
use \App\Models\Taxa;
use \App\Models\Cliente;

class PeoplesController extends Component
{
    use WithPagination;

    public $nome, $cpf_cliente, $mae, $pai, $idade, $quadra, $numero, $cemiterio_id;
    public $processo, $tp_sepultura='Escolha', $taxa_id, $valor_taxa, $valor_pago, $pago, $cor, $sexo;
    public $dt_obito, $dt_sepultamento, $hora_sepultamento, $latitude, $lat_long;
    public $longitude, $obs, $causa_id=1, $cemiterio='Escolha', $funeraria_id='Escolha', $user_id;
    public $selected_id, $search, $action=1, $cemiterios, $funerarias, $taxas, $causas;
    private $pagination = 5;

    public function render()
    {
        $this->cemiterios = Cemiterio::get();
        $this->funerarias = Funeraria::get();
        $this->taxas = Taxa::get();
        $this->causas = Causa::get();

        if(strlen($this->search) > 0){
            if(intval($this->search)===0){
                $info = Pessoa::where('nome', 'like', '%'.$this->search.'%')
                    ->orderBy('dt_obito', 'desc')
                    ->paginate($this->pagination);
            }
            else {
                $info = Pessoa::where('numero', '=', $this->search)
                    ->orderBy('dt_obito', 'desc')
                    ->paginate($this->pagination);
            }
        }
        else {
            $info = Pessoa::orderBy('dt_obito', 'desc')
                    ->paginate($this->pagination);

        }

        return view('livewire.pessoas.pessoas-controller', ["info" => $info]);
    }


    public function updatingSearch()
    {
        $this->gotoPage(1);
    }

    public function doAction($action)
    {
        $this->action = $action;
    }

    public function edit($id)
    {
        $record = Pessoa::findOrFail($id);

        $this->selected_id = $id;
        $this->cpf_cliente = $record->cpf_cliente;
        $this->nome = $record->nome;
        $this->pai = $record->pai;
        $this->mae = $record->mae;
        $this->idade = $record->idade;
        $this->quadra = $record->quadra;
        $this->numero = $record->numero;
        $this->processo = $record->processo;

        $this->pago = $record->pago;
        $this->cor = $record->cor;
        $this->sexo = $record->sexo;
        $this->valor_taxa = $record->valor_taxa;

        $this->tp_sepultura = $record->tp_sepultura;

        $this->funeraria_id = $record->funerarias->id;
        $this->cemiterio_id = $record->cemiterios->id;

        $this->cemiterio = $record->cemiterio;
        $this->causa_id = $record->causas->id;
        $this->taxa_id = $record->taxa_id;

        $this->lat_long = $record->lat_long;
        $this->latitude = $record->latitude;
        $this->longitude = $record->longitude;

        $this->obs = $record->obs;
        $this->dt_obito = date_format($record->dt_obito,'Y-m-d');
        $this->dt_sepultamento = date_format($record->dt_sepultamento,'Y-m-d');
        $this->hora_sepultamento = $record->hora_sepultamento;

        $this->latlong();

        $this->action = 2;

    }

    public function StoreOrUpdate()
    {
        $this->validate([
            'dt_obito' => ['required', 'before_or_equal:dt_sepultamento'],
            'dt_sepultamento' => ['required', 'after_or_equal:dt_obito'],
            'nome' => 'required',
            'quadra' => ['required','string','max:4'],
            'numero' => ['required', 'int'],
            'tp_sepultura' => 'Required|not_in:Escolha',
            'cemiterio_id' => 'Required|not_in:Escolha',
            'funeraria_id' => 'Required|not_in:Escolha',
            'causa_id' => 'Required|not_in:Escolha',
        ]);


        $this->lat_long = $this->latitude .','.$this->longitude;

        if($this->hora_sepultamento == "") $this->hora_sepultamento = null;

        if($this->selected_id <= 0)
        {
            $record = Pessoa::create([
            'nome' => $this->nome,
            'cpf_cliente' => $this->cpf_cliente,
            'mae' => $this->mae,
            'pai' => $this->pai,
            'idade' => $this->idade,
            'quadra' => $this->converteMaiusculo($this->quadra),
            'numero' => $this->numero,
            'processo' => $this->processo,
            'tp_sepultura' => $this->tp_sepultura,
            'valor_taxa' => $this->valor_taxa,
            'pago' => ($this->processo ? 'S' : 'N'),
            'cor' => $this->cor,
            'sexo' => $this->sexo,
            'dt_obito'  => $this->dt_obito,
            'dt_sepultamento'  => $this->dt_sepultamento,
            'hora_sepultamento' => $this->hora_sepultamento,

            'latitude' => $this->latitude,
            'longitude' => $this->longitude,

            'lat_long' => $this->lat_long,
            'obs' => $this->converteMaiusculo($this->obs),
            'cemiterio_id' => $this->cemiterio_id,
            'funeraria_id' => $this->funeraria_id,

            'causa_id' => $this->causa_id,
            'taxa_id' => $this->taxa_id,

            'user_id' => auth()->user()->id,
            ]);
        }
        else{
            $record = Pessoa::find($this->selected_id);

            $record->update([
            'nome' => $this->nome,
            'cpf_cliente' => $this->cpf_cliente,
            'mae' => $this->mae,
            'pai' => $this->pai,
            'idade' => $this->idade,
            'quadra' => $this->converteMaiusculo($this->quadra),
            'numero' => $this->numero,
            'processo' => $this->processo,
            'tp_sepultura' => $this->tp_sepultura,
            'valor_taxa' => $this->valor_taxa,
            'pago' => ($this->processo ? 'S' : 'N'),
            'cor' => $this->cor,
            'sexo' => $this->sexo,
            'dt_obito'  => $this->dt_obito,
            'dt_sepultamento'  => $this->dt_sepultamento,
            'hora_sepultamento' => $this->hora_sepultamento,

            'latitude' => $this->latitude,
            'longitude' => $this->longitude,

            'lat_long' => $this->lat_long,
            'obs' => $this->converteMaiusculo($this->obs),
            'cemiterio_id' => $this->cemiterio_id,
            'funeraria_id' => $this->funeraria_id,

            'causa_id' => $this->causa_id,
            'taxa_id' => $this->taxa_id,

            'user_id' => auth()->user()->id,
            ]);
        }

        if($this->selected_id)
            $this->emit('msgok', 'Registro atualizado com exito');
        else
            $this->emit('msgok', 'Registro criado com exito');

        $this->resetInput();
    }

    public function resetInput()
    {
        $this->cpf_cliente = '';
        $this->nome = '';
        $this->pai = '';
        $this->mae = '';
        $this->idade = '';
        $this->quadra = '';
        $this->numero = '';
        $this->processo = '';
        $this->pago = 'N';
        $this->cor = '';
        $this->sexo = '';
        $this->valor_taxa = 0.00;
        $this->tp_sepultura = 'Escolha';
        $this->cemiterio_id = 'Escolha';
        $this->funeraria_id = 'Escolha';
        $this->causa_id = 'Escolha';
        $this->taxa_id = 'Escolha';
        $this->user_id ='';
        $this->lat_long ='';
        $this->latitude ='';
        $this->longitude ='';
        $this->obs ='';
        $this->dt_obito = null;
        $this->dt_sepultamento = null;
        $this->hora_sepultamento = null;

        $this->selected_id = null;
        $this->action = 1;
        $this->search = '';
    }

    public function nomeUpper()
    {
        $this->nome = $this->converteMaiusculo($this->nome);
    }
    public function paiUpper()
    {
        $this->pai = $this->converteMaiusculo($this->pai);
    }
    public function maeUpper()
    {
        $this->mae = $this->converteMaiusculo($this->mae);
    }

    public function destroy($id)
    {
        if($id) {
            $record = Pessoa::where('id', $id);
            $record->delete();
            $this->resetInput();
            $this->emit('msgok','Registro eliminado com exito');
        }
    }

    protected $listeners = [
        'deleteRow' => 'destroy',
        'exportarPdf' => 'exportarPdf'
    ];

    function Cpf() {

        if(strlen(trim($this->cpf_cliente)) == 0) return '';

        if(!$this->validaCpf($this->cpf_cliente)){
            $this->emit('msg-error','CPF/CNPJ é inválido');

            return '';
        }

        if (strlen(trim($this->cpf_cliente)) == 11) {

            return substr($this->cpf_cliente, 0, 3) . '.' . substr($this->cpf_cliente, 3, 3) . '.' . substr($this->cpf_cliente, 6, 3) . '-' . substr($this->cpf_cliente, 9);

        }

        elseif (strlen(trim($this->cpf_cliente)) == 14) {

            return substr($this->cpf_cliente, 0, 2) . '.' . substr($this->cpf_cliente, 2, 3) . '.' . substr($this->cpf_cliente, 5, 3) . '/' . substr($this->cpf_cliente, 8, 4) . '-' . substr($this->cpf_cliente, 12, 2);

        }

        return $this->cpf_cliente;

     }

    function validaCpf($value)
    {
        if(strlen($value) == 0) return;

        $c = preg_replace('/\D/', '', $value);

        if (strlen($c) == 11) {
            if (strlen($c) != 11 || preg_match("/^{$c[0]}{11}$/", $c)) {
                return false;
            }

            for ($s = 10, $n = 0, $i = 0; $s >= 2; $n += $c[$i++] * $s--);

            if ($c[9] != ((($n %= 11) < 2) ? 0 : 11 - $n)) {
                return false;
            }

            for ($s = 11, $n = 0, $i = 0; $s >= 2; $n += $c[$i++] * $s--);

            if ($c[10] != ((($n %= 11) < 2) ? 0 : 11 - $n)) {
                return false;
            }

            return true;

        }
        $b = [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
        if (strlen($c) != 14) {
            return false;

        }

        // Remove sequências repetidas como "111111111111"
        // https://github.com/LaravelLegends/pt-br-validator/issues/4

        elseif (preg_match("/^{$c[0]}{14}$/", $c) > 0) {
            return false;
        }

        for ($i = 0, $n = 0; $i < 12; $n += $c[$i] * $b[++$i]);

        if ($c[12] != ((($n %= 11) < 2) ? 0 : 11 - $n)) {
            return false;
        }

        for ($i = 0, $n = 0; $i <= 12; $n += $c[$i] * $b[$i++]);

        if ($c[13] != ((($n %= 11) < 2) ? 0 : 11 - $n)) {
            return false;
        }

        return true;
    }

    public function verificaProcesso()
    {
        if(intval($this->processo) > 0){
            if(strlen($this->processo) <= 4){

                session()->flash('msg-error', 'Processo inválido...');
                $this->validate(['processo' => 'min:5']) ;
                $this->pago = 'N';
                return false;
            }
            $this->pago = 'S';
            if($this->taxa_id){
                $this->valor_taxa = $this->taxas[$this->taxa_id-1]->valor;
            } else {
                $this->valor_taxa = 0.00;
            }
        }
        else
        {
            $this->pago = 'N';
            $this->valor_taxa = 0.00;
        }
    }

}
