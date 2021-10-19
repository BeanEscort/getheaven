<?php

namespace App\Http\Livewire\Cemiterios;

use Livewire\Component;
use Livewire\WithPagination;

use App\Models\Cemiterio;

class CemiteriosComponent extends Component
{
    use WithPagination;

    public $nome;
    public $selected_id, $search;
    public $action = 1, $pagination = 5;
    public $cidade = '';
    public function render()
    {
        if(strlen($this->search) > 0)
        {
            $info = Cemiterio::where('nome', 'like', '%'.$this->search.'%')
                ->paginate($this->pagination);

        }
        else{
            $info = Cemiterio::orderBy('cemiterios.id', 'asc')                
                ->paginate($this->pagination);

        }
        
        return view('livewire.cemiterios.cemiterios-component', [
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
        $record = Cemiterio::find($id);
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
            $cajon = Cemiterio::create([
                'nome' => $this->nome,
            ]);
        }
        else{
            $record = Cemiterio::find($this->selected_id);
            $record->update([
                'nome' => $this->nome,
            ]);
        }

        if($this->selected_id)        
            $this->emit('msgok', 'Cemitério atualizado com exito');
        else 
            $this->emit('msgok', 'Cemitério criado com exito');
        
        $this->resetInput();
    }

    public function destroy($id)
    {
        if($id) {
            $record = Cemiterio::where('id', $id);
            $record->delete();
            $this->resetInput();
            $this->emit('msgok','Registro eliminado com exito');
        }
    }

    protected $listeners = [
        'deleteRow' => 'destroy'
    ];

}
