<div class="row layout-top-spacing">
    @if($action == 1)
    <div class="col-xl-12 col-lg-12 col-md-12 col-12 layout-spacing">
        <div class="widget-content-area br-4">
            <div class="widget-header">
                <div class="row">
                    <div class="col-xl-12 text-center">
                        <h5><b>Taxas</b></h5>
                    </div>
                </div>
            </div>
            @include('common.search', ['create' => 'taxas_create'])
            @include('common.alerts')
            <div class="col-lg-3 col-md-3 col-sm-12">
                <button wire:click.prevent="AtualizaTaxa()" class="btn btn-primary btn-lg btn-block">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-dollar-sign"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
                ATUALIZA TAXA</button>
            </div> 
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped table-checkable table-highlight-head mb-4">
                    <thead>
                        <tr>
                            <th class="">ID</th>
                            <th class="">Tipo</th>
                            <th class="">Valor</th>
                            <th class="">Criado em</th>
                            <th class="text-center">Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($info as $r)
                        <tr>
                            <td><p class="mb-0">{{$r->id}}</p></td>
                            <td>{{$r->tipo}}</td>
                            <td>{{$r->valor}}</td>
                            <td>{{\Carbon\Carbon::parse($r->created_at)->format('d/m/Y')}}</td>
                            <td class="text-center">
                                @include('common.actions',['edit' => 'taxas_edit', 'destroy' => 'taxas_destroy'])
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{$info->links()}}
            </div>
        </div>
    </div>
    @elseif($action == 2)
        @include('livewire.taxas.form')
    @endif
<script type="text/javascript">

function Confirm(id)
{
    let me = this
        swal({
            title: 'CONFIRMAR',
            text: 'CONFIRMA A EXCLUSÃO DO REGISTRO?',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Excluir',
            cancelButtonText: 'Cancelar',
            closeOnConfirm: false
            },
            function() {
                console.log('ID', id);
                window.livewire.emit('deleteRow', id)
                toastr.success('info','Registro eliminado com êxito')
                swal.close()
        })
}

document.addEventListener('DOMContentLoaded', function () {
    
})

</script>
    
</div>


