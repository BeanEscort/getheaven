<?php

namespace App\Http\Livewire\Users;

use Livewire\WithPagination;
use Livewire\Component;
use App\Exception\Handler;
use App\Traits\GenericTrait;
use Illuminate\Database\QueryException;
use \App\Models\User; 
use DB;

class UsersComponent extends Component
{
	use WithPagination;
	use GenericTrait;

	//properties
	public  $tipo ='Escolha',$name,$domain,$email,$orgao,$password, $logo;
	public  $selected_id, $search;   						
    public  $action = 1, $event=false;             						
    private $pagination = 5;         						
    public  $tipos, $user_id;
    
	public function mount()
	{
		$user_id = auth()->user()->id;

		$this->domain = auth()->user()->domain;
		$this->orgao = auth()->user()->orgao;
		$this->logo = auth()->user()->logo;
	}

    public function render()
    {
    	if(strlen($this->search) > 0)
    	{
    		$info = User::where('name', 'like', '%' .  $this->search . '%')
    			->paginate($this->pagination);
    		
    	}
    	else {

    		$info = User::orderBy('id','desc')			
    		->paginate($this->pagination);
    		
		}
		
		return view('livewire.users.users-component', [
			'info' => $info,
		]);

    }

    //permite la búsqueda cuando se navega entre el paginado
    public function updatingSearch()
    {
    	$this->gotoPage(1);
    }

    //activa la vista edición o creación
    public function doAction($action)
    {
    	$this->resetInput();
    	$this->action = $action;

    }

	//método para reiniciar variables
    private function resetInput()
    {
    	$this->name = '';
    	$this->tipo = 'Escolha';    	
    	$this->email = '';    	
    	$this->password = '';    	
    	$this->selected_id = null;       
    	$this->action = 1;
    	$this->search = '';
        
    }

    //buscamos el registro seleccionado y asignamos la info a las propiedades
    public function edit($id)
    {
    	$record = User::findOrFail($id);
    	$this->selected_id = $id;
    	$this->name = $record->name;    	
    	$this->email = $record->email;
    	$this->tipo = $record->tipo;
    	$this->action = 2;

    }


    //método para registrar y/o actualizar registros
    public function StoreOrUpdate()
    {
		//$avatar = $this->storeAvatar();

    	$this->validate([
    		'name' => 'required',
    		'email'   => 'required|email',
    		'tipo'   => 'not_in:Escolha'
    	]);    	


    	if($this->selected_id <= 0) {  
			$this->validate([				
				'password'  => 'required',				
			]);      

    		$user =  User::create([
    			'name' => $this->name,            
    			'domain' => $this->domain,            
    			'orgao' => $this->orgao,
			'logo' => $this->logo,
    			'tipo' => $this->tipo,
    			'email' => $this->email,
				'password' => bcrypt($this->password),
				
			]);
			
    	}
    	else 
    	{
			
    		$user = User::find($this->selected_id);
    		$user->update([
    			'name' => $this->name,            
    			'domain' => $this->domain,            
    			'orgao' => $this->orgao,
	     		'logo' => $this->logo,
    			'tipo' => $this->tipo,
    			'email' => $this->email,							
				
			]);      

			if($this->password){
				$user->password = bcrypt($this->password);
				$user->save();
			}	              


		}

    	if($this->selected_id) 
    		 $this->emit('msgok', 'Usuario Atualizado');
    	else {    		
			 $this->emit('msgok', 'Atribua as FUNÇÕES de '.$this->tipo.' para este usuário.');
			 $this->emit('msgok', 'Usuario Criado');
		}
    	$this->resetInput();
	}
	
    //escuchar eventos y ejecutar acción solicitada
    protected $listeners = [
		'deleteRow'     => 'destroy',
		'avatarUpload' => 'handleFileUpload'        
	];  
	
	public function handleFileUpload($imageData)
	{	
		$this->event = true;
		$this->avatar = $imageData;		
	}


   //método para eliminar un registro dado
    public function destroy($id)
    {

	DB::beginTransaction();

    try {

        $usuario = User::findOrFail($id);

        //1
        $usuario->forceDelete();
        DB::rollback();

        //2
        $usuario = User::findOrFail($id);
        $usuario->delete();

        //3
        DB::commit();

        //4
    } catch (QueryException $e) {
        DB::rollback();
        $usuario = array('mensagem' => 'impossível excluir esse dado');
	session()->flash('danger', 'N      o foi poss      vel excluir este usu      rio, existem dados relacionados a ele!');
	$this->emit('msg-error', 'Não foi possível excluir este usuário, existem dados relacionados a ele!');
    }

        return $usuario;

/*

    	if ($id) {
    		$record = User::where('id', $id)->first();

		try {

    			if( $record->delete()){

				session()->flash('danger', 'N      o foi poss      vel excluir este usu      rio, existem dados relacionados a ele!');
                        	return false;
			}
			$this->resetInput();
		} catch (Exception $e) {
			session()->flash('danger', 'Não foi possível excluir este usuário, existem dados relacionados a ele!');
			return false;
		}
    	}
*/
    }
  
}
