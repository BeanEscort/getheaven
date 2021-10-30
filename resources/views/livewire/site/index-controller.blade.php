
<div class="p-6">
    <div class="content">
        <div class="card">
	<div class="card-head">
            <h3 style="text-align: center;"> Consulta Sepultos</h3>
            <div class="row">
                @if ($recount > 0)
                <!-- SEARCH FORM -->
                <div class="col-lg-4 col-md-4 col-sm-8">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1"><svg xmlns="https://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg></span>
                        </div>
                        <input type="text" wire:model="search" class="form-control" placeholder="Pesquisar Nome, Sepultura, Mãe" aria-label="notification" aria-describedby="basic-addon1">
                    </div>
                </div>
               
                <div class="col-lg-3 col-md-3 col-sm-8">
                    <div class="input-group">
                        <select wire:model.lazy="cemiterio_id" class="form-control">
                            <option value="Escolha">Escolha o Cemitério</option>
                            @foreach($cemiterios as $c)
                                <option value="{{$c->id}}">{{$c->nome}}</option>
                            @endforeach
                        </select>

                    </div>
                </div>
                @endif
                
               
            </div>
	    </div>
            <div class="card-body">
                @if($info->count()>0)

                <table id="pessoas" class="table table-striped table-bordered table-hover table-responsive"
                    style="width:100%">
                    <thead class="thead-dark">
                        <tr>
                            <th width="40%">Nome</th>
                            <th width="30%">Mãe</th>
                            <th width="5%">Quadra</th>
                            <th width="8%">Número</th>
                            <th width="12%">Falecimento</th>
                            <th width="5%">&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($info as $pessoa)
                        <tr>
                            <td>{{$pessoa->nome}}</td>
                            <td>{{$pessoa->mae}}</td>
                            <td>{{$pessoa->quadra}}</td>
                            <td>{{$pessoa->numero}}</td>
                            <td>{{date('d/m/Y', strtotime($pessoa->dt_obito))}}</td>
                            <td>
                                <x-jet-button wire:click="ShowModal({{ $pessoa->id }})" class="btn btn-sm btn-success">

                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                </x-jet-button>

                            </td>
                        </tr>
                        @endforeach
                    </tbody>

                    <tfoot class="thead-dark">
                        <tr>
                            <th>Nome</th>
                            <th>Mãe</th>
                            <th width="50px">Quadra</th>
                            <th width="50px">Número</th>
                            <th width="60px">Falecimento</th>
                            <th width="50px">&nbsp;</th>
                    </tfoot>
                </table>
                @else
                    <div class="text-center">
                        <h2>Banco de Dados sem informações.</h2>
                    </div>
                @endif
            </div>
            <div class="card-footer">
            {{ $info->appends(['search' => $search])->links() }}
            </div>


            <!-- Modal -->
	<div class="py-6 pb-64">
            <x-jet-dialog-modal wire:model="modalFormVisible">
                <x-slot name="title">

                    <h4> {{ __('Visualizando') }}</h4>

                </x-slot>
                <x-slot name="content">
                    
                    <div class="row space-y-1" style="border-style: ridge; border-color: sian;">
                        <div class="form-group col-lg-6 col-md-6 col-sm-4">
                            <x-jet-label for="quadra" value="{{ __('Quadra') }}" />

                            <x-jet-input id="quadra" class="form-control block w-full" type="text" wire:model.debounce.800ms="quadra"/>

                        </div>

                        <div class="form-group col-lg-6 col-md-6 col-sm-4">
                            <x-jet-label for="numero" value="{{ __('Número') }}" />
                            <x-jet-input id="numero" class="form-cont,rol block w-full" type="text" wire:model.debounce.800ms="numero"/>

                        </div>

                        <div class="form-group col-lg-12 col-md-12 col-sm-12">
                            <x-jet-label for="nome" value="{{ __('Nome') }}" />
                            <x-jet-input id="nome" class="form-control block w-full" type="text" wire:model.debounce.800ms="nome"/>

                        </div>
                        <div class="form-group col-lg-4 col-md-4 col-sm-4">
                            <x-jet-label for="dt_obito" value="{{ __('Óbito') }}" />
                            <x-jet-input id="dt_obito" class="form-control block w-full" type="text" wire:model.debounce.800ms="dt_obito"/>

                        </div>
                        <div class="form-group col-lg-4 col-md-4 col-sm-4">
                            <x-jet-label for="dt_sepultamento" value="{{ __('Sepultado em') }}" />
                            <x-jet-input id="dt_sepultamento" class="form-control block w-full" type="text" wire:model.debounce.800ms="dt_sepultamento"/>

                        </div>

                        <div class="form-group col-lg-8 col-md-8 col-sm-5">
                            <x-jet-label for="cemiterio" value="{{ __('Cemiterio') }}" />
                            <x-jet-input id="cemiterio" class="form-control block w-100" type="text" wire:model.debounce.800ms="cemiterio"/>

                        </div>
                    </div>
                </x-slot>

                <x-slot name="footer">
                   {{--  @if($recount > 0)
                        <x-jet-button  wire:click="ShowMap()" wire:loading.attr="disabled">
                            {{ __('Mapa') }}
                        </x-jet-button>
                    @endif
                     --}}
		    @if(intval($latlong)!=0)
		    <a class="btn btn-primary" href="https://www.google.pt/maps?q={{$latlong}}&zoom=16" target="_blank">Google Maps</a>
		    @endif
                    <x-jet-secondary-button wire:click="$toggle('modalFormVisible')" wire:loading.attr="disabled">
                        {{ __('Fechar') }}
                    </x-jet-secondary-button>
                </x-slot>
                
            </x-jet-dialog-modal>
	    </div>
        </div>
    </div>

</div>

{{-- 
<x-jet-dialog-modal wire:model="modalMapVisible">
    <x-slot name="title">

        <h2> {{ __('Visualizando') }}</h2>

    </x-slot>
    <x-slot name="content">
        <div id="mapa" style="width: 600px; height: 500px;">
            Aqui vai o mapa
        </div>            
    </x-slot>

    <x-slot name="footer">
                
        <x-jet-secondary-button wire:click="$toggle('modalMapVisible')" wire:loading.attr="disabled">
            {{ __('Fechar') }}
        </x-jet-secondary-button>
    </x-slot>
    
</x-jet-dialog-modal>




<script type="text/javascript">
    var divMapa = document.getElementById('mapa');
    navigator.geolocation.getCurrentPosition(fn_ok, fn_mal);

    function fn_mal() { }
    function fn_ok ( rta ) {
        var lat = rta.coords.latitude;
        var lon = rta.coords.longitude;

        var gLatLon = new google.maps.LatLng(lat, lon);
        var objConfig = {
            zoom: 17,
            center: gLatLon
        }
        var gMapa = new google.maps.Map(divMapa, objConfig);
        var objConfigMarker = {
            position: gLatLon,
            map: gMapa, title: "Você está aqui."
        }
        var gMarker = new google.maps.Marker(objConfigMarker);
    } 
</script> --}}
