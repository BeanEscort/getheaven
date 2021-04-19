<?php

namespace App\Http\Livewire\Funerarias;

use Livewire\Component;
use Livewire\WithPagination;

use \App\Models\Funeraria;

class FunerariasComponent extends Component
{
    use WithPagination;

    public $nome;
    public $selected_id, $search;
    public $action = 1, $pagination = 5;
    public function render()
    {
        if(strlen($this->search) > 0)
        {
            $info = Funeraria::where('nome', 'like', '%'.$this->search.'%')
                ->paginate($this->pagination);
        }
        else{
            $info = Funeraria::orderBy('funerarias.id', 'asc')                
                ->paginate($this->pagination);
        }
        
        return view('livewire.funerarias.funerarias-component', [
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
        $record = Funeraria::find($id);
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
            $cajon = Funeraria::create([
                'nome' => $this->nome,
            ]);
        }
        else{
            $record = Funeraria::find($this->selected_id);
            $record->update([
                'nome' => $this->nome,
            ]);
        }

        if($this->selected_id)        
            $this->emit('msgok', 'Funerária atualizado com exito');
        else 
            $this->emit('msgok', 'Funerária criado com exito');
        
        $this->resetInput();
    }

    public function destroy($id)
    {
        if($id) {
            $record = Funeraria::where('id', $id);
            $record->delete();
            $this->resetInput();
            $this->emit('msgok','Registro eliminado com exito');
        }
    }

    protected $listeners = [
        'deleteRow' => 'destroy'
    ];

}
