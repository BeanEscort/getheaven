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
        @include('common.search', ['create' => 'users_create'])      
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped table-checkable table-highlight-head mb-4">
                <thead>
                    <tr>                                                                           
                        <th class="">NOME</th>
                        
                        <th class="">EMAIL</th>
                        @can('users_tipo')
                        <th class="">TIPO</th>
                        @endcan
                        <th class="text-center">AÇÕES</th>
                        
                    </tr>
                </thead>
                <tbody>
                   @foreach($info as $r)
                   <tr>
                     
                    <td><p class="mb-0">{{$r->name}}</p></td>
                    
                    <td>{{$r->email}}</td>
                    @can('users_tipo')
                    <td>{{$r->tipo}}</td>
                    @endcan
                    <td class="text-center">
                        @include('common.actions',['edit' => 'users_edit', 'destroy' => 'users_destroy'])
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
        window.livewire.emit('deleteRow', id)    
        toastr.success('info', 'Registro eliminado com êxito')
        swal.close()   
    })
  
    }

</script>
