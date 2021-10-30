<div class="row layout-top-spacing">
    @if($action == 1)
    <div class="col-xl-12 col-lg-12 col-md-12 col-12 layout-spacing">
        <div class="widget-content-area br-4">
            <div class="widget-header">
                <div class="row">
                    <div class="col-xl-12 text-center">
                        <h5><b>Causas de Morte</b></h5>
                    </div>
                </div>
            </div>
            @include('common.search', ['create' => 'causas_create'])
            @include('common.alerts')

            <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped table-checkable table-highlight-head mb-4">
                    <thead>
                        <tr>
                            <th class="">ID</th>
                            <th class="">CAUSA DE MORTE</th>
                            <th class="">Criado em</th>
                            <th class="text-center">Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($info as $r)
                        <tr>
                            <td><p class="mb-0">{{$r->id}}</p></td>
                            <td>{{$r->nome}}</td>
                            <td>{{\Carbon\Carbon::parse($r->created_at)->format('d/m/Y')}}</td>
                            <td class="text-center">
                                @include('common.actions',['edit' => 'causas_edit', 'destroy' => 'causas_destroy'])
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
        @include('livewire.causas.form')
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

