
<div class="row layout-top-spacing">
    @if($action == 1)
    <div class="col-xl-12 col-lg-12 col-md-12 col-12 layout-spacing">
        <div class="widget-content-area br-4">
            <div class="widget-header">
                <div class="row">
                    <div class="col-xl-12 text-center">
                        <h5><b>Requerimento</b></h5>
                    </div>
                </div>
            </div>
            @include('common.search'{{--, ['create' => 'requerimento_create']--}})
            <div>
                @if (session()->has('message'))
                    <div class="alert alert-success">
                        {{ session('message') }}
                    </div>
                @endif
            </div>
            <div>
                @if (session()->has('danger'))
                    <div class="alert alert-danger">
                        {{ session('danger') }}
                    </div>
                @endif
            </div>

            <div class="table-responsive">
                <table style="border-style: ridge;" class="table table-bordered table-hover table-striped table-checkable table-highlight-head mb-4">
                    <thead>
                        <tr>
                            <th class="">ID</th>
                            <th class="">NOME DO FALECIDO</th>
                            <th class="">QUADRA</th>
                            <th class="">NÚMERO</th>
                            <th class="">DATA ÓBITO</th>
                            <th class="text-center" width="100">Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($info as $r)
                        <tr>
                            <td>
                                <p class="mb-0">{{$r->id}}</p>
                            </td>
                            <td>{{$r->nome}}</td>
                            <td>{{$r->quadra}}</td>
                            <td>{{$r->numero}}</td>
                            <td>{{\Carbon\Carbon::parse($r->dt_obito)->format('d/m/Y')}}</td>
                            <td class="text-center" width="150">
                                <ul class="table-controls">
                               {{-- @can('requerimentos_pdf') --}}
                                    <li>
                                        <a href="{!! url('geraPdf', $r->id) !!} " target="_blank" data-toggle="tooltip"
                                            data-placement="top" title="Imprimir"><svg xmlns="http://www.w3.org/2000/svg"
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
                               {{-- @can('requerimento_edit')--}}
                                    <li>
                                        <a href="javascript:void(0);" wire:click="edit({{$r->id}})"
                                            data-toggle="tooltip" data-placement="top" title="Alterar"><svg
                                                xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-edit-2 text-success">
                                                <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z">
                                                </path>
                                            </svg></a>
                                    </li>
                                {{--@endcan--}}
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
    @include('livewire.requerimento.form')
    @elseif($action == 3)
    @include('livewire.requerimento.buscaPessoa')
    @endif
</div>
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

    </script>

