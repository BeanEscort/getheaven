<div class="widget-content-area">
    <div class="widget-one">

        <h3>Inserir / Editar Pessoa</h3>
        @include('common.messages')
        @include('common.alerts')
        <div class="row mt-2" style="border-style: ridge; border-color: sian;">

            <div class="form-group col-lg-2 col-md-2 col-sm-4 mt-2">
                <label for="">QUADRA</label>
                <input type="text" wire:model.lazy="quadra" class="form-control text-center @error('quadra') is-invalid @enderror" maxlength="6"
                    placeholder="Ex.: 999999" autofocus>
                    @if($errors->get('quadra'))
                            <p class="text-danger">O campo Quadra é obrigatório.</p>
                    @endif
            </div>
            <div class="form-group col-lg-2 col-md-2 col-sm-8 mt-2">
                <label>NÚMERO</label>
                <input type="number" wire:model.lazy="numero" class="form-control text-center @error('numero') is-invalid @enderror">
                @if($errors->get('numero'))
                    <p class="text-danger">O Número da sepultura é obrigatório.</p>
                @endif
            </div>
            <div class="form-group col-lg-2 col-md-2 col-sm-8 mt-2">
                <label for="">PROCESSO</label>
                <input type="text" class="form-control" wire:model.lazy="processo" wire:blur="verificaProcesso()">
            </div>
            <div class="form-group col-lg-2 col-md-2 col-sm-4 mt-2">
                <label for="">PAGO?</label>
                <input type="text" class="form-control" wire:model.lazy="pago">
            </div>
            <div class="form-group col-lg-2 col-md-2 col-sm-4 mt-2">
                <label for="">LATITUDE</label>
                <input type="text" id="lat" name="lat" class="lat form-control" wire:model.lazy="latitude">
            </div>
            <div class="form-group col-lg-2 col-md-2 col-sm-4 mt-2">
                <label for="">LONGITUDE</label>
                <input type="text" id="long" name="long" class="long form-control" wire:model.lazy="longitude">
            </div>
            <div class="form-group col-lg-8 col-md-8 col-sm-12 mb-8">
                <label for="">NOME</label>
                <input type="text" id="nome" class="form-control @error('nome') is-invalid @enderror" wire:model.lazy="nome" placeholder="Nome do Falecido"
                    maxlenght="80" wire:blur="nomeUpper()">
                    @if($errors->get('nome'))
                            <p class="text-danger">O Nome do Falecido é obrigatório.</p>
                    @endif
            </div>
            <div class="form-group col-lg-4 col-md-4 col-sm-12 mb-8">
                <label for="">Idade</label>
                <input type="text" class="form-control" wire:model.lazy="idade" placeholder="Idade">
            </div>

            <div class="form-group col-lg-3 col-md-3 col-sm-12 mb-8">
                <label for="">Data Óbito</label>
                <input type="date" class="form-control @error('dt_obito') is-invalid @enderror" wire:model.lazy="dt_obito">
                @if($errors->get('dt_obito'))
                    <p class="text-danger">A Data do óbito é obrigatória.</p>
                @endif
            </div>
            <div class="form-group col-lg-3 col-md-3 col-sm-12 mb-8">
                <label for="">Data Sepultamento</label>
                <input type="date" class="form-control @error('dt_sepultamento') is-invalid @enderror" wire:model.lazy="dt_sepultamento">
                @if($errors->get('dt_sepultamento'))
                    <p class="text-danger">A Data de sepultamento é obrigatório.</p>
                @endif
            </div>

            <div class="form-group col-lg-3 col-md-3 col-sm-12 mb-8">
                <label for="">Hora</label>
                <input type="time" class="form-control" wire:model.lazy="hora_sepultamento">
            </div>

            <div class="form-group col-lg-3 col-md-3 col-sm-12 mb-8">
                <label for="">CPF/CNPJ Cliente</label>
                <input type="text" class="form-control" wire:keydown.enter = "Cpf()"  wire:model.lazy="cpf_cliente" wire:blur="Cpf()">
            </div>


            <div class="form-group col-lg-3 col-md-3 col-sm-6 mb-8">

                <label for="">CEMITÉRIO </label>

                <br>
                <div class="input-group">
                    <select wire:model.lazy="cemiterio_id" class="form-control @error('cemiterio_id') is-invalid @enderror">
                        <option value="Escolha" disabled>Escolha</option>
                        @foreach($cemiterios as $c)
                        <option value="{{$c->id}}">{{$c->nome}}</option>
                        @endforeach

                    </select>
                    <div class="input-group-prepend">

                        <a class="text-dark input-group-text" wire:click="createShowModal(1)" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-circle"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>
                        </a>

                    </div>
                </div>
                    @if($errors->get('cemiterio_id'))
                            <p class="text-danger">Escolha o Cemitério.</p>
                    @endif
            </div>
            <div class="form-group col-lg-3 col-md-3 col-sm-6 mb-8">
                <label for="">FUNERÁRIA</label><br>
                <div class="input-group">
                    <select wire:model.lazy="funeraria_id" class="form-control @error('funeraria_id') is-invalid @enderror">
                        <option value="Escolha" disabled>Escolha</option>
                        @foreach($funerarias as $f)
                        <option value="{{$f->id}}">{{$f->nome}}</option>
                        @endforeach

                    </select>
                    <div class="input-group-prepend">

                        <a class="text-dark input-group-text"  wire:click="createShowModal(2)" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-circle"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>
                        </a>

                    </div>
                </div>
                @if($errors->get('funeraria_id'))
                    <p class="text-danger">A Funerária é obrigatória.</p>
                @endif
            </div>

            <div class="form-group col-lg-3 col-md-3 col-sm-6 mb-8">
                <label for="">TIPO SEPULTURA</label><br>
                <div class="input-group">
                        <select wire:model.lazy="tipo_id" class="form-control @error('tipo_id') is-invalid @enderror">
                            <option value="Escolha" disabled>Escolha</option>
                            @foreach($tipos as $tp)
                            <option value="{{$tp->id}}">{{$tp->tipo}}</option>
                            @endforeach
                        </select>
                        <div class="input-group-prepend">

                            <a class="text-dark input-group-text" wire:click="createShowModal(3)" type="button" aria-haspopup="true" aria-expanded="false">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-circle"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>
                            </a>

                        </div>
                    </div>
                @if($errors->get('tipo_id'))
                            <p class="text-danger">O Tipo da sepultura é obrigatório.</p>
                    @endif
            </div>
            <div class="form-group col-lg-3 col-md-3 col-sm-6 mb-8">
                <label for="">TAXA REFERENTE A</label><br>
                <div class="input-group">
                        <select wire:model.lazy="taxa_id" class="form-control @error('taxa_id') is-invalid @enderror">
                            <option value="Escolha" disabled>Escolha</option>
                            @foreach($taxas as $t)
                            <option value="{{$t->id}}">{{$t->tipo}} - R${{number_format($t->valor,2)}}</option>
                            @endforeach
                        </select>
                        <div class="input-group-prepend">

                            <a class="text-dark input-group-text" wire:click="createShowModal(4)" type="button" aria-haspopup="true" aria-expanded="false">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-circle"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>
                            </a>

                        </div>
                    </div>
                @if($errors->get('taxa_id'))
                    <p class="text-danger">A Referência é obrigatória.</p>
                @endif
            </div>

            <div class="form-group col-lg-5 col-md-5 col-sm-12 mb-8">
                <label for="">PAI</label>
                <input type="text" class="form-control" wire:model.lazy="pai" wire:blur="paiUpper()" placeholder="...">
            </div>
            <div class="form-group col-lg-5 col-md-5 col-sm-12 mb-8">
                <label for="">MÃE</label>
                <input type="text" class="form-control" wire:model.lazy="mae" wire:blur="maeUpper()" placeholder="...">
            </div>
            <div class="form-group col-lg-2 col-md-2 col-sm-12 mb-8">
                <label for="">Valor Pago</label>
                <input type="number" class="form-control text-right" wire:model.lazy="valor_taxa" placeholder="0,00">
            </div>

            <div class="form-group col-lg-3 col-md-3 col-sm-12 mb-8">
                <label for="">COR</label><br>
                <select wire:model.lazy="cor" class="form-control">
                    <option value="Escolha" disabled>Escolha</option>

                    <option value="BRANCA">BRANCA</option>
                    <option value="PRETA">PRETA</option>
                    <option value="PARDA">PARDA</option>
                    <option value="MORENA">MORENA</option>
                    <option value="MULATA">MULATA</option>
                    <option value="OUTRA">OUTRA</option>

                </select>
            </div>
            <div class="form-group col-lg-3 col-md-3 col-sm-12 mb-8">
                <label for="">SEXO</label><br>
                <select wire:model.lazy="sexo" class="form-control">
                    <option value="Escolha" disabled>Escolha</option>

                    <option value="MASCULINO">MASCULINO</option>
                    <option value="FEMININO">FEMININO</option>

                </select>
            </div>
            <div class="form-group col-lg-6 col-md-6 col-sm-12 mb-8">
                <label for="">CAUSA DA MORTE</label><br>
                <div class="input-group">
                    <select wire:model.lazy="causa_id" class="form-control">
                        <option value="Escolha" disabled>Escolha</option>
                        @foreach($causas as $c)
                        <option value="{{$c->id}}">{{$c->nome}}</option>
                        @endforeach
                    </select>
                    <div class="input-group-prepend">

                        <a class="text-dark input-group-text" wire:click="createShowModal(5)" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-circle"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>
                        </a>

                    </div>
                </div>
                @if($errors->get('causa_id'))
                    <p class="text-danger">A Causa de Morte é obrigatória.</p>
                @endif
            </div>

            <div class="row">
                <div class="form-group col-lg-12 col-md-12 col-sm-12  ">
                    <button type="button" wire:click="doAction(1)" class="btn btn-dark ml-4 mr-1">
                        <i class="mbri-left"></i> Voltar
                    </button>
                    <button type="button" wire:click.prevent="StoreOrUpdate() " class="btn btn-primary">
                        <i class="mbri-success"></i> Salvar
                    </button>
                </div>
            </div>
           {{-- <div id="map" style="height:50%; width:50%;"></div> --}}
            @include('livewire.requerimento.modalcemiterio')

            @include('livewire.requerimento.modalfuneraria')

            @include('livewire.requerimento.modaltiposepultura')
            @include('livewire.requerimento.modaltaxa')
            @include('livewire.requerimento.modalcausa')
            {{-- @include('livewire.pessoas.modalcemiterio')
            <input type="hidden" id="cemiterio_id" value="0">

            @include('livewire.pessoas.modalfuneraria')
            <input type="hidden" id="funeraria_id" value="0">

            @include('livewire.pessoas.modalcausa')
            <input type="hidden" id="causa_id" value="0"> --}}
        </div>
<div id="map"></div>
    </div>

  <script>
        var lat = document.querySelector("#lat").value;
        var long = document.querySelector("#long").value;

	var nome = document.querySelector("#nome").value;


	function initMap() {

         	const myLatLng = {
			lat: lat, 
			lng: long 
		};         

		const map = new google.maps.Map(document.getElementById("map"), {           
			zoom: 4,           
			center: myLatLng,         
		});
	        new google.maps.Marker({           
			position: myLatLng,           
			map,           
			title: nome,
	         });       
	}
</script>
   <script 
	src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBsx03RimZ8OqThSsxvz2ElSUMlz8bPfEQ&callback=initMap&libraries=&v=weekly" 
async >
    </script>
</div>

