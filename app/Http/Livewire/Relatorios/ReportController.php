<?php

namespace App\Http\Livewire\Relatorios;

use App\Models\Pessoa;
use Livewire\WithPagination;
use Livewire\Component;
use Carbon\Carbon;
use PDF;

class ReportController extends Component
{
    public $data_ini; 
    public $data_fim;

    use WithPagination;


    public function render() 
    {
      
        $ini = Carbon::parse(Carbon::now())->format('Y-m-d');
        $fim = Carbon::parse(Carbon::now())->format('Y-m-d');
 
        if($this->data_ini && $this->data_fim )
        {

            $ini = Carbon::parse($this->data_ini)->format('Y-m-d');
            $fim = Carbon::parse($this->data_fim)->format('Y-m-d');   
            
        }

        $info = Pessoa::leftjoin('cemiterios as c','c.id','pessoas.cemiterio_id')
                    ->select('pessoas.*', 'c.nome as cemiterio')
                    ->whereBetween('pessoas.dt_obito', [$ini, $fim])
                    ->paginate(10);
        $total = Pessoa::whereBetween('pessoas.dt_obito', [$ini, $fim]);
        
        return view('livewire.relatorios.report-controller', [
            'info' => $info,
            'total' => $total,
        ]);
    }

    
    public function nameMethod()
    {
        
        $ini = Carbon::parse($this->data_ini)->format('Y-m-d');
        
        $fim = Carbon::parse($this->data_fim)->format('Y-m-d');

        return redirect()->route('pdf', [$ini, $fim]); //pdf_alfa
     
    }
}
