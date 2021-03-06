<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use App\Traits\GenericTrait;
use Carbon\Carbon;
use App\Models\Pessoa;
use App\Models\Empresa;
use App\Models\Taxa;
use App\Models\Tipo;
use App\Models\Cliente;
use App\Models\Cemiterio;
use App\Exports\PessoasExport;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
	use GenericTrait;

    public function reportPDF($tenant, $userid, $dateFrom=null, $dateTo=null)
    {
	$data=[];

//	$empresa = Empresa::get();
//	$logo = $empresa->logo;

	$from = Carbon::parse($dateFrom)->format('Y-m-d');
	$to = Carbon::parse($dateTo)->format('Y-m-d');

	if($userid == 0)
	{
		$data = Pessoa::join('cemiterios as c','c.id','pessoas.cemiterio_id')
		->select('pessoas.*','c.nome as cemiterio')
		->whereBetween('pessoas.dt_obito', [$from, $to])
		->orderBy('pessoas.dt_obito','asc')
		->get();
	} else {
		$data = Pessoa::join('cemiterios as c','c.id','pessoas.cemiterio_id')
                ->select('pessoas.*','c.nome as cemiterio')
                ->whereBetween('pessoas.dt_obito', [$from, $to])
		->where('cemiterio_id', $userid)
		->orderBy('pessoas.dt_obito','asc')
                ->get();
	}
	$cemiterio =  $userid == 0 ? 'Todos' : Cemiterio::find($userid)->nome;
	$pdf = PDF::loadView('pdf.report', compact('data', 'cemiterio', 'dateFrom', 'dateTo'));

	return $pdf->stream('pessoasReport.pdf');
    }

    public function reportExcel($tenant,$userId, $dateFrom=null, $dateTo=null)
    {
	$reportName = 'Relatorio por data Obito_' . uniqid() . '.xlsx';
	return Excel::download(new PessoasExport($userId, $dateFrom, $dateTo),$reportName);
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
        $pessoa->telefone = $this->fone($pessoa->telefone);
        $pessoa->celular1 = $this->fone($pessoa->celular1);
        $pessoa->celular2 = $this->fone($pessoa->celular2);
        if($pessoa->cep) {
            $pessoa->cep = $this->cep($pessoa->cep);
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

}
