    <div class="row layout-top-spacing">    
       <div class="col-xl-12 col-lg-12 col-md-12 col-12 layout-spacing">
       @if($action == 1)                
          
        <div class="widget-content-area br-4">
           <div class="widget-header">
            <div class="row">
                <div class="col-xl-12 text-center">
                    <h5><b>Usuarios do Sistema</b></h5>
                </div> 
            </div>
        </div>
	@if(auth()->user()->tipo === 'Admin')
	        @include('common.search', ['create' => 'users_create'])
	@endif
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped table-checkable table-highlight-head mb-4">
                <thead>
                    <tr>                                                                           
                        <th class="">NOME</th>
                        
                        <th class="">EMAIL</th>
                   	{{-- (tipo') --}}
                        <th class="">FUNÇÃO</th>
                       {{-- @endcan --}}
			
                        <th class="text-center">AÇÕES</th>
                        
                    </tr>
                </thead>
                <tbody>
                   @foreach($info as $r)
                   <tr>
                     
                    <td><p class="mb-0">{{$r->name}}</p></td>
                    
                    <td>{{$r->email}}</td>
               	    
                    <td>{{$r->tipo === 'Admin' ? '' : $r->tipo}}</td>
               
                    <td class="text-center">

			@if( auth()->user()->tipo === 'Admin' )
				@if( auth()->user()->email !== $r->email)
                        		@include('common.actions',['edit' => true, 'destroy' => $r->tipo === 'Admin'])
				@endif
			@endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{$info->links()}}
    </div>

</div>     

@elseif($action == 2)
@include('livewire.users.form')		
@endif  
</div>
<script type="text/javascript">

    function Confirm(id)
    {

       let me = this
       swal({
        title: 'CONFIRMAR',
        text: 'DESEJA ELIMINAR ESTE REGISTRO?',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Aceitar',
        cancelButtonText: 'Cancelar',
        closeOnConfirm: false
    },
    function() {
        console.log('ID', id);
	try {
        if(window.livewire.emit('deleteRow', id))    
        	toastr.success('info', 'Registro eliminado com êxito')
	} catch (error){
		toastr.warning('Erro', 'Ocorreu um erro')
	}
	swal.close()
    })
  
    }

</script>
