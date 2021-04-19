<div class="row layout-top-spacing">
    @if($action == 1)
    <div class="col-xl-12 col-lg-12 col-md-12 col-12 layout-spacing">
        <div class="widget-content-area br-4">
            <div class="widget-header">
                <div class="row">
                    <div class="col-xl-12 text-center">
                        <h5><b>Clientes</b></h5>
                    </div>
                </div>
            </div>
            @include('common.search', ['create' => 'clientes_create'])
            @include('common.alerts')

            <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped table-checkable table-highlight-head mb-4">
                    <thead>
                        <tr>
                            <th class="">ID</th>
                            <th class="">CPF / CNPJ</th>
                            <th class="">NOME DO CLIENTE</th>
                            <th class="">CEP</th>
                            <th class="">ENDEREÇO</th>
                            <th class="">NRO</th>
                            <th class="">BAIRRO</th>
                            <th class="text-center" width="100">Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($info as $r)
                        <tr>
                            <td><p class="mb-0">{{$r->id}}</p></td>
                            <td>{{$r->cpf}}</td>
                            <td>{{$r->nome}}</td>
                            <td>{{$r->cep}}</td>
                            <td>{{$r->endereco}}</td>
                            <td>{{$r->nro}}</td>
                            <td>{{$r->bairro}}</td>
                            <td class="text-center">
                                @include('common.actions',['edit' => 'clientes_edit', 'destroy' => 'clientes_destroy'])
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
        @include('livewire.clientes.form')
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

