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
            @include('common.search')
            @include('common.alerts')

            <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped table-checkable table-highlight-head mb-4">
                    <thead>
                        <tr>
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

                                    <li>
                                        <a href="javascript:void(0);" wire:click="show({{$r->id}})"
                                            data-toggle="tooltip" data-placement="top" title="Edit"><svg
                                                xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-edit-2 text-success">
                                                <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z">
                                                </path>
                                            </svg></a>
                                    </li>

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
    @include('livewire.site.form')
    @endif
    
</div>