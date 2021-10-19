<?php

namespace App\Http\Livewire\Taxas;

use Livewire\Component;
use Livewire\WithPagination;

use \App\Models\Taxa;
use \App\Models\Ufir;
use Illuminate\Support\Facades\DB;

class TaxasController extends Component
{
    use WithPagination;

    public $tipo;
    public $valor;
    public $total_ufir, $ufir, $ufir_id;
    public $selected_id, $search;
    public $action = 1, $pagination = 5;

    public function mount()
    {
        $ufir = Ufir::where('ano', date_format(now(),'Y'))->first();
	if(!$ufir){
	  $this->ufir =  0.00;
	  $this->ufir_id = 1;
	} else {
          $this->ufir = $ufir->valor_ufir;
          $this->ufir_id = $ufir->id;
	}
    }

    public function render()
    {
        if(strlen($this->search) > 0)
        {
            $info = Taxa::where('tipo', 'like', '%'.$this->search.'%')
                ->paginate($this->pagination);

        }
        else{
            $info = Taxa::orderBy('taxas.id', 'asc')                
                ->paginate($this->pagination);

        }
        return view('livewire.taxas.taxas-controller', [
            'info' => $info
        ]);
    }


    public function AtualizaTaxa()
    {
        $todos = Taxa::all();

        $this->emit('msgok', 'Atualizando...');
        foreach ($todos as $valor) {            
            $valor_ufir = number_format($valor->total_ufir * $this->ufir, 2);

            $valorAtual = $valor->update([               
                'valor' => $valor_ufir,
            ]);
            
        }      
        if($valorAtual) $this->emit('msgok', 'Atualizado com sucesso!');
   
    }

    public function updateValor()
    {
        $this->valor = number_format($this->total_ufir * $this->ufir, 2);
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
        $this->tipo = '';
        $this->valor = 0.00;
        $this->total_ufir = 0.00;
        $this->selected_id = null;
        $this->action = 1;
        $this->search = '';
    }

    public function edit($id)
    {
        $record = Taxa::find($id);
        $this->selected_id = $id;
        $this->tipo = $record->tipo;
        $this->valor = $record->valor;
        $this->total_ufir = $record->total_ufir;
        $this->ufir_id = $record->ufir_id;
        $this->action = 2;        
    }


    public function StoreOrUpdate()
    {
        
        $this->validate([
            'tipo' => 'required',
            'total_ufir' => 'required',
            
        ]);

        if($this->selected_id <= 0)
        {
            $cajon = Taxa::create([
                'tipo' => $this->tipo,
                'valor' => number_format($this->total_ufir * $this->ufir, 2),
                'total_ufir' => $this->total_ufir,
                'ufir_id' => $this->ufir_id,
            ]);
        }
        else{
            $record = Taxa::find($this->selected_id);
            
            $record->update([
                'tipo' => $this->tipo,
                'valor' => number_format($this->total_ufir * $this->ufir->valor_ufir, 2),
                'total_ufir' => $this->total_ufir,
                'ufir_id' => $this->ufir_id,
            ]);
        }

        if($this->selected_id)        
            $this->emit('msgok', 'Taxa atualizada com exito');
        else 
            $this->emit('msgok', 'Taxa criada com exito');
        
        $this->resetInput();
    }

    public function destroy($id)
    {
        if($id) {
            $record = Taxa::where('id', $id);
            $record->delete();
            $this->resetInput();
            $this->emit('msgok','Registro eliminado com exito');
        }
    }

    protected $listeners = [
        'deleteRow' => 'destroy'
    ];
}
