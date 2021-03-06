<?php

namespace App\Http\Livewire\Site;

use Livewire\Component;
use Livewire\WithPagination;

use App\Models\Pessoa;
use App\Models\Cemiterio;
use App\Models\Tipo;

class IndexController extends Component
{
    use WithPagination;

    public $cemiterio_id='Escolha', $modalFormVisible = false;
    public $search, $cemiterios,$nome,$pai,$mae,$idade,$quadra,$numero;
    public $dt_obito, $dt_sepultamento, $cemiterio, $tipo, $latlong, $recount;
    private $pagination = 6;

    
    public function mount()
    {
        $this->resetPage();
       
    }

    public function render()
    {
        $this->cemiterios = Cemiterio::get();

        $this->recount = Cemiterio::count();

        $info = Pessoa::orderBy('dt_obito', 'desc')
                        ->paginate($this->pagination);
	$pesqNome = 0;
        if(strlen($this->search) > 0){
            if(intval($this->search)===0){
		$pesqNome = 1;

                $info = Pessoa::where('nome', 'like', '%'.$this->search.'%')

                    ->orderBy('dt_obito', 'desc')
                    ->paginate($this->pagination);
            }
            else {
		$pesqNome = 2;

                $info = Pessoa::where('numero', '=', $this->search)
                    ->orderBy('dt_obito', 'desc')
                    ->paginate($this->pagination);
            }
            
        }

        
            if($this->cemiterio_id !== 'Escolha'){
		
		if($pesqNome===1){
		  $info = Pessoa::where('nome', 'like', '%'.$this->search.'%')
			->where('cemiterio_id', '=', $this->cemiterio_id)->orderBy('dt_obito', 'desc')->paginate(6);
		} else if($pesqNome===2){
		 $info = Pessoa::where('numero', '=', $this->search)
			 ->where('cemiterio_id', '=', $this->cemiterio_id)->orderBy('dt_obito', 'desc')->paginate(6);
		} else  
                  $info = Pessoa::where('cemiterio_id', '=', $this->cemiterio_id)->orderBy('dt_obito', 'desc')->paginate(6);
                
            }
            if(empty($info)) $this->mensagem = 'Nada foi encontrado com essa pesquisa.';

        return view('livewire.site.index-controller', ['info' => $info]);
    }
    
    public function ShowModal($id)
    {               
        $this->loadModel($id);
               
        $this->modalFormVisible = true; 
              
    }

    
    public function loadModel($id)
    {
        $data = Pessoa::find($id);
        $tipo = Tipo::find($data->tipo_id);
        $cemiterio = Cemiterio::find($data->cemiterio_id);

        $this->nome = $data->nome;
        $this->pai = $data->pai;
        $this->mae = $data->mae;
        $this->idade = $data->idade;
        $this->quadra = $data->quadra;
        $this->numero = $data->numero;
        $this->dt_obito = date_format($data->dt_obito,'d/m/Y');
        $this->dt_sepultamento = date_format($data->dt_sepultamento,'d/m/Y');
        $this->tipo = $tipo->tipo;
        $this->cemiterio = $cemiterio->nome;
        $this->latlong = $data->latitude.','.$data->longitude;
    }
}
