<?php

namespace App\Http\Livewire\Causas;

use Livewire\Component;
use Livewire\WithPagination;

use \App\Models\Causa;

class CausasController extends Component
{
    use WithPagination;

    public $nome;
    public $selected_id, $search;
    public $action = 1, $pagination = 5;
    public function render()
    {
        if(strlen($this->search) > 0)
        {
            $info = Causa::where('nome', 'like', '%'.$this->search.'%')
                ->paginate($this->pagination);

        }
        else{
            $info = Causa::orderBy('causas.id', 'asc')                
                ->paginate($this->pagination);

        }
        return view('livewire.causas.causas-controller', [
            'info' => $info
        ]);
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
        $this->nome = '';
        $this->selected_id = null;
        $this->action = 1;
        $this->search = '';
    }

    public function edit($id)
    {
        $record = Causa::find($id);
        $this->selected_id = $id;
        $this->nome = $record->nome;
        $this->action = 2;        
    }


    public function StoreOrUpdate()
    {
        
        $this->validate([
            'nome' => 'required',
        ]);

        if($this->selected_id <= 0)
        {
            $cajon = Causa::create([
                'nome' => $this->nome,
            ]);
        }
        else{
            $record = Causa::find($this->selected_id);
            $record->update([
                'nome' => $this->nome,
            ]);
        }

        if($this->selected_id)        
            $this->emit('msgok', 'Causa de Morte atualizado com exito');
        else 
            $this->emit('msgok', 'Causa de Morte criado com exito');
        
        $this->resetInput();
    }

    public function destroy($id)
    {
        if($id) {
            $record = Causa::where('id', $id);
            $record->delete();
            $this->resetInput();
            $this->emit('msgok','Registro eliminado com exito');
        }
    }

    protected $listeners = [
        'deleteRow' => 'destroy'
    ];

}
