<div class="main-content">
    <div class="layout-px-spacing">
        <div class="col-12 layout-spacing">
            <div class="widget-content-area">
                <div class="widget-one">
                    <h4 class="text_center mb-5">Relatório por data</h4>
                    <div class="row">
                        <div class="col-sm-12 col-md-3 col-lg-3">
                            Data Inicial
                            <div class="form-group">
                                <input wire:model.lazy="data_ini" type="text"
                                    class="form-control flatpickr flatpickr-input active">
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-3 col-lg-3">
                            Data Final
                            <div class="form-group">
                                <input wire:model.lazy="data_fim" type="text"
                                    class="form-control flatpickr flatpickr-input active">
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-1 col-lg-1 text-left"> 
                        <a href="{{ url('pdf', [$data_ini, $data_fim]) }} " target="_blank" data-toggle="tooltip"
                                            data-placement="top" title="PDF"><svg xmlns="http://www.w3.org/2000/svg"
                                                width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round" class="feather feather-printer mt-4 ">
                                                <polyline points="6 9 6 2 18 2 18 9"></polyline>
                                                <path 
                                                    d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2">
                                                </path>
                                                <rect x="6" y="14" width="12" height="8"></rect>
                                            </svg></a>
                            <!-- <button type="submit" class="btn btn-info mt-4 mobile-only">Ver</button> -->
                        </div>
                        {{-- <div class="col-sm-12 col-md-1 col-lg-1 text-left">
                            <button type="button" class="btn btn-dark mt-4 mobile-only" onclick="{{ url('pdf', [$data_ini, $data_fim]) }}" target="_blank" target="_blank">Exportar</button>
                        </div> --}}
                        <div class="col-sm-12 com-md-3 col-lg-3 offset-lg-1">
                            <b>Data de Consulta</b> {{\Carbon\Carbon::now()->format('d/m/Y')}}
                            <br>
                            <b>Qtde. Registros</b> {{$total->count()}}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="table-responsive mt-3">
                        <table
                            class="table table-bordered table-hover table-striped table-checkable table-highlight mb-4">
                            <thead>
                                <th class="text-center">CÓDIGO</th>
                                <th class="text-center">NOME</th>
                                <th class="text-center">QUADRA</th>
                                <th class="text-center">NÚMERO</th>
                                <th class="text-center">FALECIDO EM</th>
                                
                            </thead>
                            <tbody>
                                @foreach($info as $r)
                                <tr>
                                    <td class="text-center">{{$r->id}}</td>
                                    <td class="text-center">{{$r->nome}}</td>
                                    <td class="text-center">{{$r->quadra}}</td>
                                    <td class="text-center">{{$r->numero}}</td>
                                    <td class="text-center">{{\Carbon\Carbon::parse($r->dt_obito)->format('d/m/Y')}}
                                    </td>
                                    
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th class="text-right" colspan="9"></th>
                                    <th class="text-center" colspan="1"></th>
                                </tr>
                            </tfoot>
                        </table>
                        {{$info->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>