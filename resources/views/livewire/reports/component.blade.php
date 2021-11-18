<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget">
            <div class="widget-heading">
                <h4 class="card-title text-center"><b>{{$componentName}}</b></h4>
            </div>

            <div class="widget-content">
                <div class="row">
                    <div class="col-sm-12 col-md-3">
                        <div class="row">
                            <div class="col-sm-12">
                                <h6>Escolha um Cemitério </h6>
                                <div class="form-group">
                                    <select wire:model="cemiterioid" class="form-control">
                                        <option value="0">Todos</option>
                                        @foreach($cemiterios as $cem)
                                            <option value="{{$cem->id}}">{{$cem->nome}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-2">
                                <h6>Data Desde</h6>
                                <div class="form-group">
                                    <input type="text" wire:model.lazy="dateFrom" class="form-control flatpickr" placeholder="Clique para escolher">
                                </div>
                            </div>
                            <div class="col-sm-12 mt-2">
                                <h6>Data Até</h6>
                                <div class="form-group">
                                    <input type="text" wire:model.lazy="dateTo" class="form-control flatpickr" placeholder="Clique para escolher">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <button wire:click="$refresh" class="btn btn-dark btn-block">
                                    Consultar
                                </button>
                                <a class="btn btn-dark btn-block {{ count($data) < 1 ? 'disabled' : ''}}"
                                href="{{ url('reports/pdf'.'/'.$cemiterioid.'/'.$dateFrom
                                .'/'.$dateTo) }}" target="_blank">Gerar PDF</a>
				<a class="btn btn-dark btn-block {{ count($data) < 1 ? 'disabled' : ''}}"
                                href="{{ url('reports/excel'.'/'.$cemiterioid.'/'.$dateFrom
                                .'/'.$dateTo) }}" target="_blank">Gerar EXCEL</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-9">
                        <!--TABELA -->
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped mt-1">
                                <thead class="text-white" style="background: #3B3F5C">
                                    <tr>
                                        <th class="table-th text-white text-center">Nome</th>
                                        <th class="table-th text-white text-center">Quadra</th>
                                        <th class="table-th text-white text-center">Número</th>
                                        <th class="table-th text-white text-center">Falecimento</th>
                                        <th class="table-th text-white text-center" width="50px"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(count($data) < 1)
                                        <tr><td colspan="5"><h5>Sem Resultados</h5></td></tr>                                        
                                    @endif
                                    @foreach($data as $p)
                                        <tr>
                                            <td><h6>{{$p->nome}}</h6></td>
                                            <td class="text-center"><h6> {{$p->quadra}}</h6></td>
                                            <td class="text-center"><h6>{{$p->numero}}</h6></td>
                                            <td class="text-center">
                                                <h6>{{\Carbon\Carbon::parse($p->dt_obito)->format('d-m-Y')}}</h6>
                                            </td>
                                            <td class="text-center" width="50px">
                                                <button wire:click.prevent="getDetails({{$p->id}})"
                                                 class="btn btn-dark btn-sm">
                                                    <i class="">Detalhes</i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('livewire.reports.detail')
</div>

<script>
    document.addEventListener("DOMContentLoaded", function(){
        flatpickr(document.getElementsByClassName("flatpickr"),{
            enableTime: false,
            dateFormat: "d-m-Y",
            locale: {
                firstDayofWeek: 1,
                weekdays: {
                    shorthand: ["Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "Sáb"],
                    longhand: [
                    "Domingo",
                    "Segunda-feira",
                    "Terça-feira",
                    "Quarta-feira",
                    "Quinta-feira",
                    "Sexta-feira",
                    "Sábado",
                    ],
                },
                months: {
                    shorthand: [
                    "Jan",
                    "Fev",
                    "Mar",
                    "Abr",
                    "Mai",
                    "Jun",
                    "Jul",
                    "Ago",
                    "Set",
                    "Out",
                    "Nov",
                    "Dez",
                    ],
                    longhand: [
                    "Janeiro",
                    "Fevereiro",
                    "Março",
                    "Abril",
                    "Maio",
                    "Junho",
                    "Julho",
                    "Agosto",
                    "Setembro",
                    "Outubro",
                    "Novembro",
                    "Dezembro",
                    ],
                },
            }

       //     window.livewire.on("show-modal", Msg => {
       //         $("#modalDetails").modal("show")
       //     });
        });
    });
</script>
