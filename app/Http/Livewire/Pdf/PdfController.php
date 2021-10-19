<?php

namespace App\Http\Livewire\Pdf;

use Livewire\Component;

use Carbon\Carbon;
use App\Traits\GenericTrait;
use PDF;
use App\Models\Taxa;
//use App\Models\Reserva;
use App\Models\Pessoa;

class PdfController extends Component
{
    use GenericTrait;

    public function render($id)
    {
        
        return view('livewire.pdf.pdf-controller');
    }

    public function geraPdf($id)
    {
        dd($id);
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
        //$pessoa = $requerimento[0];
        dd($requerimento);
        if(! $pessoa->cpf) 
        {
            session()->flash('msg-error', 'O Requerente não foi encontrado, complete os dados antes de  continuar.');
            return redirect()->back(); 
        }
        
        $pessoa->cpf = $this->cpf($pessoa->cpf);
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
        
        $pdf = PDF::loadView('livewire.pdf.pdf-controller', compact('pessoa'))->setPaper('a4', 'portrait');

        $fileName = time().$pessoa->cpf.date("dmY");
        return $pdf->stream($fileName.'.pdf');
    }
}
