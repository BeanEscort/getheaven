<?php

namespace App\Http\Livewire\Pessoas;

use Carbon\Carbon;
use App\Models\Tipo;
use App\Models\Ufir;
use App\Models\Rota;

use \App\Models\Taxa;
use \App\Models\Causa;
use \App\Models\Pessoa;
use Livewire\Component;
use \App\Models\Cemiterio;
use App\Models\Cliente;
use \App\Models\Funeraria;
use App\Traits\GenericTrait;
use Illuminate\Support\Facades\App;
use Livewire\WithPagination;

class PessoasController extends Component
{
    use WithPagination;
    use GenericTrait;

    public $cnome = null, $causanome = null, $fnome = null, $nome, $cpf_cliente, $mae, $pai, $idade, $quadra, $numero;
    public $processo, $tipo_id='Escolha', $taxa_id="Escolha", $valor_taxa, $valor_pago, $pago, $cor, $sexo;
    public $dt_obito, $dt_sepultamento, $hora_sepultamento, $latitude;
    public $longitude, $obs, $causa_id='Escolha', $cemiterio_id='Escolha', $funeraria_id='Escolha', $user_id;
    public $selected_id, $search, $action=1, $cemiterios, $funerarias, $taxas, $causas, $tipos;
    public $tipotaxa, $total_ufir, $ufir_id, $ufir, $tipo;
    private $pagination = 5;

    public $modalFormVisible = false;
    public $modalFunerariaVisible = false, $modalTipoVisible = false;
    public $modalTaxaVisible = false, $modalCausaVisible = false;

    public function mount()
    {

        $ufir = Ufir::where('ano', date_format(now(),'Y'))->first();
        if($ufir){
            $this->ufir = $ufir->valor_ufir;
            $this->ufir_id = $ufir->id;
        } else {
            $this->ufir = 0.00;
        }

        $this->tipos = Tipo::get();
        $this->cemiterios = Cemiterio::get();
        $this->funerarias = Funeraria::get();
        $this->taxas = Taxa::get();
        $this->causas = Causa::get();
    }

    public function render()
    {

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

        $this->cemiterios = Cemiterio::create($this->modelData($this->cnome));

        $this->cnome = null;
        $this->modalFormVisible = false;
        session()->flash('message', 'Registro criado com exito');
        $this->cnome = null;
    }

    public function createTaxa()
    {

        if($this->tipotaxa==null){
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

        $this->taxas = Taxa::create([
            'tipo' => $this->tipotaxa,
            'valor' => $this->valor_taxa,
            'total_ufir' => $this->total_ufir,
            'ufir_id' => $this->ufir_id,
        ]);

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

        $this->funerarias = Funeraria::create($this->modelData($this->fnome));

        $this->fnome = null;
        session()->flash('message', 'Registro criado com exito');

    }

    public function createTipo()
    {
        if($this->tipo ==''){
            session()->flash('danger', 'Tipo de Sepultura é obrigatório');
            return;
        }

        if(Tipo::where('tipo', $this->tipo)->count() > 0) {
            session()->flash('danger', 'Tipo de Sepultura já cadastrado!');
            $this->tipo = null;
            return;
        }

        $this->tipos = Tipo::create( ['tipo' => $this->tipo]);

        session()->flash('message', 'Registro criado com exito');
        $this->tipo = null;
    }

    public function modelData($campo)
    {
        return [
            'nome' => $this->converteMaiusculo($campo),
        ];
    }
    public function createCausa()
    {
        if($this->causanome==null){
            session()->flash('danger', 'Causa de Morte é obrigatório');
            return;
        }

        Causa::create($this->modelData($this->causanome));

        $this->causanome = null;
        session()->flash('message', 'Registro criado com exito');
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
        }else if ($q === 5){
            $this->modalCausaVisible = true;
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

        $this->tipo_id = $record->tipo_id;

        $this->funeraria_id = $record->funeraria_id;
        $this->cemiterio_id = $record->cemiterio_id;

        $this->causa_id = $record->causa_id;
        $this->taxa_id = $record->taxa_id;

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
            'quadra' => ['required','string','max:6'],
            'numero' => ['required', 'int'],
            'tipo_id' => 'Required|not_in:Escolha',
            'taxa_id' => 'Required|not_in:Escolha',
            'cemiterio_id' => 'Required|not_in:Escolha',
            'funeraria_id' => 'Required|not_in:Escolha',
            'causa_id' => 'Required|not_in:Escolha',
        ]);

        if($this->hora_sepultamento == "") $this->hora_sepultamento = null;

        if($this->selected_id <= 0)
        {
	    $this->latlong();

            $record = Pessoa::create([
            'nome' => $this->nome,
            'cpf_cliente' => $this->cpf_cliente,
            'mae' => $this->mae,
            'pai' => $this->pai,
            'idade' => $this->idade,
            'quadra' => $this->converteMaiusculo($this->quadra),
            'numero' => $this->numero,
            'processo' => $this->processo,
            'tipo_id' => $this->tipo_id,
            'valor_taxa' => $this->valor_taxa,
            'pago' => ($this->processo ? 'S' : 'N'),
            'cor' => $this->cor,
            'sexo' => $this->sexo,
            'dt_obito'  => $this->dt_obito,
            'dt_sepultamento'  => $this->dt_sepultamento,
            'hora_sepultamento' => $this->hora_sepultamento,
	    
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,

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
            'tipo_id' => $this->tipo_id,
            'valor_taxa' => $this->valor_taxa,
            'pago' => ($this->processo ? 'S' : 'N'),
            'cor' => $this->cor,
            'sexo' => $this->sexo,
            'dt_obito'  => $this->dt_obito,
            'dt_sepultamento'  => $this->dt_sepultamento,
            'hora_sepultamento' => $this->hora_sepultamento,

            'latitude' => $this->latitude,
            'longitude' => $this->longitude,

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
        $this->tipo_id = 'Escolha';
        $this->cemiterio_id = 'Escolha';
        $this->funeraria_id = 'Escolha';
        $this->causa_id = 'Escolha';
        $this->taxa_id = 'Escolha';
        $this->user_id ='';
        
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
        'exportarPdf' => 'exportarPdf',
    ];

    public function exportarPdf($id) {
        $mes = ['janeiro', 'fevereiro', 'março', 'abril', 'maio', 'junho', 'julho', 'agosto', 'setembro', 'outubro', 'novembro', 'dezembro'];


        $pessoa = Pessoa::where('id',$id)->first();
	
	if($pessoa->cliente_id)
        	$cliente = Cliente::find($pessoa->cliente_id);
	else
		$cliente = Cliente::where('cpf',$pessoa->cpf_cliente)->first();

        if(! $cliente)
        {
            toastr()->error('O Requerente não foi encontrado, complete os dados antes de  continuar.');
            return redirect()->back();
        }

        if(intval($pessoa->funeraria_id)>0){
            $funeraria = Funeraria::where('id', $pessoa->funeraria_id)->first();
            $pessoa->funeraria = $funeraria->nome;
        } else
            $pessoa->funeraria = '';

        $cemiterio = Cemiterio::where('id', $pessoa->cemiterio_id)->first();
        $pessoa->cemiterio = $cemiterio->nome;


        $cliente->cpf = $this->cpf($cliente->cpf);

        $cliente->cep = $this->cep($cliente->cep);

        if($cliente->fone_fixo)
            $cliente->fone_fixo = $this->fone($cliente->fone_fixo);
        if($cliente->celular1)
            $cliente->celular1 = $this->fone($cliente->celular1);


        $taxa = Taxa::where('id',$pessoa->id_taxa)->first();

        $pessoa->ex_obito = \Carbon\Carbon::parse($pessoa->dt_obito)->format('Y-m-d');

        if($pessoa->hora_sepult != null)
            $pessoa->hora_sepult = \Carbon\Carbon::parse($pessoa->hora_sepult)->format('H:i');

        $dia =  date('d', strtotime($pessoa->ex_obito));
        $mesn = date('m', strtotime($pessoa->ex_obito));
        $ano  = date('Y', strtotime($pessoa->ex_obito));

        $mesn = (int)$mesn-1;
        $pessoa->ex_obito = $dia.' de '.$mes[$mesn].' de '.$ano;

        if(!$taxa) $taxa->valor = [0];

        $pdf     = PDF::loadView('pdf.pessoas', compact('pessoa', 'cliente', 'taxa'))->setPaper('a4', 'portrait');
        $fileName = time().$cliente->cpf.date("dmy");

        return $pdf->stream($fileName.'.pdf');

    }

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
            if(intval($this->taxa_id)>0){
		$mtaxa = Taxa::find($this->taxa_id);
                $this->valor_taxa = $mtaxa->valor;
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

    public function latlong()
    {
        $rotas = Rota::where('cemiterio_id',$this->cemiterio_id)
                ->where('quadra',$this->quadra)
                ->where('bloco',$this->tipo_id)->first();
        
        if($rotas){
            $this->latitude = $rotas->latitude;
            $this->longitude = $rotas->longitude;
        }
    }

    public function geraPdf($id)
    {

        $mes = ['janeiro', 'fevereiro', 'março', 'abril', 'maio', 'junho', 'julho', 'agosto', 'setembro', 'outubro', 'novembro', 'dezembro'];

        $requerimento = Pessoa::leftjoin('clientes as cli', 'cli.id','pessoas.cliente_id')
                    ->leftjoin('cemiterios as c', 'c.id', 'pessoas.cemiterio_id')
                    ->leftjoin('funerarias as f', 'f.id', 'pessoas.funeraria_id')
                    ->leftjoin('taxas as t', 't.id', 'pessoas.taxa_id')
                    ->leftjoin('tipo_sepulturas as ts', 'ts.id', 'pessoas.tipo_id')
                    ->leftjoin('users as u', 'u.id', 'cli.user_id')
                    ->select('pessoas.nome as falecido', 'pessoas.dt_obito', 'pessoas.dt_sepultamento','pessoas.idade', 'pessoas.tipo_id',
                    'pessoas.quadra', 'pessoas.numero', 'pessoas.mae' , 'pessoas.hora_sepultamento', 'pessoas.obs' , 'cli.*', 'c.nome as cemiterio', 'f.nome as funeraria', 'ts.tipo as tp_sepultura', 't.tipo', 't.valor', 'u.name')
                    ->where('pessoas.id', $id)
                    ->get();

       $pessoa = $requerimento[0];

        if(! $pessoa->cpf)
        {
            session()->flash('msg-error', 'O Requerente não foi encontrado, complete os dados antes de  continuar.');
            return redirect()->back();
        }

        $pessoa->cpf = $this->Cpfpdf($pessoa->cpf);
        $pessoa->telefone = $this->fone($pessoa->telefone);
        $pessoa->celular1 = $this->fone($pessoa->celular1);
        $pessoa->celular2 = $this->fone($pessoa->celular2);

        if($pessoa->hora_sepultamento != null)
            $pessoa->hora_sepultamento = \Carbon\Carbon::parse($pessoa->hora_sepultamento)->format('H:i');

        $dia =  date('d', strtotime($pessoa->dt_obito));
        $mesn = date('m', strtotime($pessoa->dt_obito));
        $ano  = date('Y', strtotime($pessoa->dt_obito));

        $now = Carbon::now()->format('Y-m-d');

        $d = date('d', strtotime($now));
        $m = date('m', strtotime($now));
        $a = date('Y', strtotime($now));

        //$mesAtual = date('m', $now);

        $mesn = (int)$mesn-1;
        $m = (int)$m-1;

        $pessoa->hoje = $d.' de '.$mes[$m].' de '.$a;

        $pessoa->ex_obito = $dia.' de '.$mes[$mesn].' de '.$ano;

        //$pessoa->hoje = $hoje;
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('livewire.pessoas.pessoas', compact('pessoa'))->setPaper('a4', 'portrait');

        $fileName = time().$pessoa->cpf.date("dmY");

        return $pdf->stream($fileName.'.pdf');
    }

    function Cpfpdf($cpf) {

        if(strlen($cpf) == 0) return '';


        if (strlen(trim($cpf)) == 11) {

            return substr($cpf, 0, 3) . '.' . substr($cpf, 3, 3) . '.' . substr($cpf, 6, 3) . '-' . substr($cpf, 9);

        }

        elseif (strlen(trim($cpf)) == 14) {

            return substr($cpf, 0, 2) . '.' . substr($cpf, 2, 3) . '.' . substr($cpf, 5, 3) . '/' . substr($cpf, 8, 4) . '-' . substr($cpf, 12, 2);

        }

        return $cpf;

     }
     function fone($fone) {

        if (!$fone) {

            return '';

        }

        $fone = trim($fone);

        if (strlen($fone) == 8) {

            return substr($fone, 0, 4).'-'.substr($fone, 4, 4);

        }

        if (strlen($fone) == 9) {

            return substr($fone, 0, 5).'-'.substr($fone, 5);

        }

        if (strlen(trim($fone)) == 10) {

            return '(' . substr($fone, 0, 2) . ') ' . substr($fone, 2, 4) . '-' . substr($fone, 6);

        }

        if (strlen(trim($fone)) == 11) {
            if(substr($fone, 0, 1) != '0'){
                return '(' . substr($fone, 0, 2) . ') ' . substr($fone, 2, 5) . '-' . substr($fone, 7);
            }
        }

        if (strlen(trim($fone)) == 11) {
            if(substr($fone, 0, 1) == '0'){
                return '(' . substr($fone, 1, 2) . ') ' . substr($fone, 2, 5) . '-' . substr($fone, 7);
            }
        }

        return $fone;

    }
}
