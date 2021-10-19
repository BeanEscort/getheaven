<div class="row layout-top-spacing">
    @if($action == 1)
    <div class="col-xl-12 col-lg-12 col-md-12 col-12 layout-spacing">
        <div class="widget-content-area br-4">
            <div class="widget-header">
                <div class="row">
                    <div class="col-xl-12 text-center">
                        <h5><b>Reserva de Sepultura</b></h5>
                    </div>
                </div>
            </div>
            @include('common.search', ['create' => 'requerimento_create'])
            @include('common.alerts')
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped table-checkable table-highlight-head mb-4">
                    <thead>
                        <tr>
                            <th class="">ID</th>
                            <th class="">CPF / CNPJ</th>
                            <th class="">NOME DO CLIENTE</th>
                            <th class="">DATA</th>
                            <th class="">QUADRA</th>
                            <th class="">NÚMERO</th>
                            
                            <th class="text-center" width="100">Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($info as $r)
                        <tr>
                            <td>
                                <p class="mb-0">{{$r->id}}</p>
                            </td>
                            <td>{{$r->cpf_cliente}}</td>
                            <td>{{$r->nome}}</td>
                            <td>{{\Carbon\Carbon::parse($r->data_cadastro)->format('d/m/Y')}}</td>
                            <td>{{$r->quadra}}</td>
                            <td>{{$r->numero}}</td>
                            
                            <td class="text-center" width="150">
                            <ul class="table-controls"> 
                              {{--  @can('requerimento_pdf') --}}
                                    <li>
                                        <a href="{!! url('reservas', $r->id) !!} " target="_blank" data-toggle="tooltip"
                                            data-placement="top" title="Edit"><svg xmlns="http://www.w3.org/2000/svg"
                                                width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round" class="feather feather-printer">
                                                <polyline points="6 9 6 2 18 2 18 9"></polyline>
                                                <path
                                                    d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2">
                                                </path>
                                                <rect x="6" y="14" width="12" height="8"></rect>
                                            </svg></a>
                                    </li>
                               {{-- @endcan --}}
                                @can('requerimento_edit')
                                    <li>
                                        <a href="javascript:void(0);" wire:click="edit({{$r->id}})"
                                            data-toggle="tooltip" data-placement="top" title="Edit"><svg
                                                xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-edit-2 text-success">
                                                <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z">
                                                </path>
                                            </svg></a>
                                    </li>
                                @endcan
                                @can('requerimento_destroy')
                                    <li>
                                        <a href="javascript:void(0);" onClick="Confirm('{{$r->id}}')"
                                            data-toggle="tooltip" data-placement="top" title="Delete"><svg
                                                xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-trash-2 text-danger">
                                                <polyline points="3 6 5 6 21 6"></polyline>
                                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3
    0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                                <line x1="10" y1="11" x2="10" y2="17"></line>
                                                <line x1="14" y1="11" x2="14" y2="17"></line>
                                            </svg></a>
                                    </li>
                                @endcan
                                </ul>
                                
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
    @include('livewire.reservas.form')
    @endif
    <script type="text/javascript">
    function Confirm(id) {
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
                toastr.success('info', 'Registro eliminado com êxito')
                swal.close()
            })
    }

    document.addEventListener('DOMContentLoaded', function() {

    })
    </script>

</div>
