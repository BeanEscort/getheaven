<div class="row layout-top-spacing">
    <div class="col-xl-12 col-lg-12 col-md-12 col-12 layout-spacing">
        @if($action == 1)

        <div class="widget-content-area br-4">
            <div class="widget-header">
                <div class="row">
                    <div class="col-xl-12 text-center">
                        <h5><b>Pessoas</b></h5>
                    </div>
                </div>
            </div>
            @include('common.search', ['create' => 'pessoas_create'])
            @include('common.alerts')

            <div class="table-responsive" style="border-style: ridge; border-color: sian;">
                <table class="table table-bordered table-hover table-striped table-checkable table-highlight-head mb-4">
                    <thead>
                        <tr style="border-bottom: ridge; ">
                            <th class="">ID</th>
                            <th class="">NOME</th>
                            <th class="">QUADRA</th>
                            <th class="">NÚMERO</th>
                            <th class="">FALECIDO EM</th>

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

                            <td class="text-center" width="150px">
                                <ul class="table-controls">
                               {{--  @can('pessoas_pdf')--}}
                                    <li>
                                        <a href="{!! url('geraPdf', $r->id) !!} " target="_blank" data-toggle="tooltip"
                                            data-placement="top" title="PDF"><svg xmlns="http://www.w3.org/2000/svg"
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
                                {{--@endcan
                                @can('pessoas_edit')--}}
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
                                {{--@endcan
                                @can('pessoas_destroy')--}}
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
                              {{--  @endcan --}}
                                </ul>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="ml-2">
                {{$info->links()}}
                </div>
            </div>
        </div>
    </div>
    @elseif($action == 2)
    @include('livewire.pessoas.form')
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

    function eventExport(eventName, id) {

        window.livewire.emit(eventName, id)

    }

    function openModal()
    {
        $('#id').val(0)
        $('.modal-title').text('Novo Cemitério')
        $('#modalCemiterio').modal('show')
    }

    function openModalFu()
    {
        $('#id').val(0)
        $('.modal-title').text('Nova Funerária')
        $('#modalFuneraria').modal('show')
    }

    function openModalCau()
    {
        $('#id').val(0)
        $('.modal-title').text('Nova Causa de Morte')
        $('#modalCausa').modal('show')
    }

    function save()
    {
        if($('#cnome').val() == '')
        {
            toastr.error('Digite o nome do novo cemitério!')
            return;
        }

        var data = JSON.stringify({
            "id" : $('#id').val(),
            "nome" : $('#cnome').val()
        });

        window.livewire.emit('createCemiterio', data)

    }
    document.addEventListener('DOMContentLoaded', function(){
        window.livewire.on('msgok', datamsg => {
            $('#modalCemiterio').modal('hide')
            $('#modalFuneraria').modal('hide')
            $('#modalCausa').modal('hide')
        })
        window.livewire.on('msg-error', datamsg => {
            $('#modalCemiterio').modal('hide')
            $('#modalFuneraria').modal('hide')
            $('#modalCausa').modal('hide')
        })
    });
    </script>

</div>
