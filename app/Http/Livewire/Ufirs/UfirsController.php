<?php

namespace App\Http\Livewire\Ufirs;

use Livewire\Component;
use \App\Models\Ufir;
use DB;

class UfirsController extends Component
{
    public $ano = 2021, $valor_anterior = 0.00, $valor_ufir = 0.00;

    public function mount()
	{
		$ufir = Ufir::orderBy('ano', 'DESC')->first();

		if($ufir){
			$this->ano = $ufir->ano;
			$this->valor_anterior = $ufir->valor_anterior;
			$this->valor_ufir = $ufir->valor_ufir;
		}
	}

    public function render()
    {
        return view('livewire.ufirs.ufirs-controller');
	}

	public function Guardar()
    {

    	$rules = [
            'ano'     => 'required',
            'valor_ufir'    => 'required',

        ];

        $customMessages = [
        	'ano.required' => 'O campo :atribute é obrigatório',
        	'valor_ufir.required' => 'O Valor da UFIR é obrigatório',

    	];

		$this->validate($rules, $customMessages);

        $this->valor_anterior = $this->valor_ufir;

    	//DB::table('ufirs')->truncate();

    	Ufir::create([
    		'ano' => $this->ano,
    		'valor_anterior' => $this->valor_anterior,
    		'valor_ufir' => $this->valor_ufir,

    	]);

		$this->emit('msgok', 'Nova UFIR adicionada...');
		
		redirect('dash');
    }
}
