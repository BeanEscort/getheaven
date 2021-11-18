<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Traits\GenericTrait;
use Barryvdh\DomPDF\Facade as PDF;
use App\Models\Taxa;
use App\Models\Reserva;
use App\Models\Pessoa;
use App\Models\Tipo;
use App\Models\Cliente;
use App\Models\Cemiterio;

class PdfController extends Controller
{
    use GenericTrait;

	public function reportPDF($tenant,$dateFrom, $dateTo)
	{
		$data = [];
	dd($dateTo.'-');
		$from = \Carbon\Carbon::parse($dateFrom)->format('d/m/Y');
		$to = \Carbon\Carbon::parse($dateFrom)->format('d/m/Y');
	
		$data = Pessoa::join('cemiterios as c', 'c.id','pessoas.cemiterio_id')
			->select('pessoas.*', 'c.nome as cemiterio')
			->whereBetween('pessoas.dt_obito', [$from, $to])
			->get();
				
		$pdf = PDF::loadview('pdf.report', compact('data','dateFrom', 'dateTo'));
	
		return $pdf->stream('pessoasReport.pdf');
	} 

    public function geraPdf($tenant, $id)
    {
	$mes = ['janeiro', 'fevereiro', 'março', 'abril', 'maio', 'junho', 'julho', 'agosto', 'setembro', 'outubro', 'novembro', 'dezembro'];
        $tipo_sepulturas = Tipo::get();
        $requerimento = Pessoa::leftjoin('clientes as cli', 'cli.id','pessoas.cliente_id')
                    ->leftjoin('cemiterios as c', 'c.id', 'pessoas.cemiterio_id')
                    ->leftjoin('funerarias as f', 'f.id', 'pessoas.funeraria_id')
                    ->leftjoin('taxas as t', 't.id', 'pessoas.taxa_id')
                    ->leftjoin('tipo_sepulturas as ts', 'ts.id', 'pessoas.tipo_id')
		    ->leftjoin('users as u','u.id','cli.user_id')
                    ->select('pessoas.nome as falecido', 'pessoas.dt_obito', 'pessoas.dt_sepultamento','pessoas.idade', 'pessoas.tipo_id',
                    'pessoas.quadra', 'pessoas.numero', 'pessoas.mae' , 'pessoas.hora_sepultamento', 'pessoas.obs' , 'cli.*', 'c.nome as cemiterio',
                     'f.nome as funeraria', 't.tipo', 't.valor', 'ts.tipo as tp_sepultura', 'u.name', 'u.domain', 'u.orgao')
                    ->where('pessoas.id', $id)
                    ->get();
                   
        if(!isset($requerimento)) {
            session()->flash('msg-error', 'Nenhum registro foi encontrado.');
            return redirect()->back();
        }

        $pessoa = $requerimento[0];
        
        if(! $pessoa->cpf)
        {
            session()->flash('msg-error', 'O Requerente não foi encontrado, complete os dados antes de  continuar.');
            return redirect()->back();
        }

	$pessoa->domain = auth()->user()->domain;
	$pessoa->orgao = auth()->user()->orgao;
	$pessoa->name = auth()->user()->name;

	$fileName = time().$pessoa->cpf.date("dmY").'.pdf';
        $pessoa->cpf = $this->CpfCli($pessoa->cpf);
        $pessoa->telefone = fone($pessoa->telefone);
        $pessoa->celular1 = fone($pessoa->celular1);
        $pessoa->celular2 = fone($pessoa->celular2);
        if($pessoa->cep) {
            $pessoa->cep = cep($pessoa->cep);
        }

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

        		
        return PDF::loadView('livewire.pessoas.p', compact('pessoa', 'tipo_sepulturas'))
                ->stream($fileName);


    }

    public function reservaPdf($tenant, $id)
    {

        $mes = ['janeiro', 'fevereiro', 'março', 'abril', 'maio', 'junho', 'julho', 'agosto', 'setembro', 'outubro', 'novembro', 'dezembro'];

        $requerimento = Reserva::leftjoin('users as u', 'u.id', 'reservas.user_id')
                    ->select('reservas.*', 'u.name', 'u.domain', 'u.orgao')
                    ->where('reservas.id', $id)
                    ->get();

	if(!isset($requerimento)) {
            session()->flash('msg-error', 'Nenhum registro foi encontrado.');
            return redirect()->back();
        }


        $pessoa = $requerimento[0];

        $taxas = Taxa::find(1);
        $pessoa->taxa='RESERVA DE '.$pessoa->tipo;
        $pessoa->valor=$taxas->valor;

        if(! $pessoa->cpf_cliente)
        {
            session()->flash('msg-error', 'O Requerente não foi encontrado, complete os dados antes de  continuar.');
            return redirect()->back();
        }

        $pessoa->cpf = $this->cpf($pessoa->cpf_cliente);
        $pessoa->telefone = $this->fone($pessoa->telefone);
        $pessoa->celular1 = $this->fone($pessoa->celular1);
        $pessoa->celular2 = $this->fone($pessoa->celular2);

        $pessoa->cep = $this->cep($pessoa->cep);

        if($pessoa->data_cadastro != null)
            $pessoa->data_cadastro = \Carbon\Carbon::parse($pessoa->data_cadastro)->format('d/m/Y');

        $dia =  date('d', strtotime($pessoa->data_cadastro));
        $mesn = date('m', strtotime($pessoa->data_cadastro));
        $ano  = date('Y', strtotime($pessoa->data_cadastro));

        $now = Carbon::now()->format('Y-m-d');

        $d = date('d', strtotime($now));
        $m = date('m', strtotime($now));
        $a = date('Y', strtotime($now));

        $mesn = (int)$mesn-1;
        $m = (int)$m-1;

        $pessoa->hoje = $d.' de '.$mes[$m].' de '.$a;

        $pessoa->data_cadastro = $dia.' de '.$mes[$mesn].' de '.$ano;

        $pdf = PDF::loadView('livewire.reservas.reservas', compact('pessoa'))->setPaper('a4', 'portrait');

        $fileName = time().$pessoa->cpf_cliente.date("dmY");
        return $pdf->stream($fileName.'.pdf');

    }

    public function nameMethod($data_ini, $data_fim)
    {

        $ini = $data_ini;
        $fim = $data_fim;

        $info = Pessoa::leftjoin('cemiterios as c','c.id','pessoas.cemiterio_id')
                    ->select('pessoas.*', 'c.nome as cemiterio')
                    ->whereBetween('pessoas.dt_obito', [$ini, $fim])->orderBy('dt_obito', 'asc')->get();

        $fileName = time().date("dmY");
        return PDF::loadView('livewire.relatorios.ordem_alfabetica', compact('info'))
                ->setPaper('a4', 'portrait')
                ->stream($fileName.'.pdf');

    }

    function Cpf($cpf) {

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
