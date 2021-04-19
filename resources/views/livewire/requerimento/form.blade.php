<div class="widget-content-area">
    <div class="widget-one">
        <form action="">
            <h3>Inserir / Editar Cliente</h3>
            @include('common.alerts')
            @include('common.messages')
            <div class="row">
                <div class="form-group col-lg-3 col-md-3 col-sm-12">
                    <label for="">CPF/CNPJ</label>
                    <input type="text" wire:keydown.enter="buscaCPF()" wire:blur="buscaCPF()" wire:model="cpf" class="form-control text-center  @error('cpf') is-invalid @enderror"
                        maxlength="20" placeholder="Digite o CPF" autofocus>

                        @if($errors->get('cpf'))
                            <p class="text-danger">Número do CPF é obrigatório.</p>
                        @endif
                </div>
                <div class="form-group col-lg-3 col-md-3 col-sm-12">
                    <label>Data</label>
                    <input type="date" wire:model="data_cadastro" class="form-control text-center  @error('data_cadastro') is-invalid @enderror">
                    @if($errors->get('data_cadastro'))
                            <p class="text-danger">Data de Cadastro é obrigatório.</p>
                    @endif
                </div>
                <div class="form-group col-lg-6 col-md-6 col-sm-12">
                    <label for="">Nome do Requerente</label>
                    <input type="text" class="form-control  @error('nomeCliente') is-invalid @enderror" wire:model.lazy="nomeCliente" wire:blur="nomeClienteUpper()">

                    @if($errors->get('nomeCliente'))
                            <p class="text-danger">O Nome do Requerente é obrigatório.</p>
                    @endif
                </div>
                <div class="form-group col-lg-3 col-md-3 col-sm-12 mb-8" wire:offline.class="bg-red-300">
                    <label for="">CEP</label>
                    <input type="text" data-js="cep" class="form-control" wire:model="cep" wire:change="buscaCep()"
                        placeholder="Somente números" maxlength="8" wire:keydown.enter="buscaCep()">

                        <div class="text-center" wire:loading wire:target="cep">
                        <div class="spinner-border"></div>
                        </div>
                </div>
                <div class="form-group col-lg-6 col-sm-12 mb-8">
                    <label for="">Endereço</label>
                    <input type="text" class="form-control  @error('logradouro') is-invalid @enderror" wire:model.lazy="logradouro" wire:blur="enderecoUpper()"
                        placeholder="...">
                        @if($errors->get('logradouro'))
                            <p class="text-danger">O Endereço é obrigatório.</p>
                        @endif
                </div>
                <div class="form-group col-lg-3 col-md-3 col-sm-12 mb-8">
                    <label for="">Nro</label>
                    <input type="text" class="form-control" wire:model.lazy="nro" placeholder="...">
                </div>
                <div class="form-group col-lg-3 col-md-3 col-sm-12 mb-8">
                    <label for="">Complemento</label>
                    <input type="text" class="form-control" wire:model.lazy="complemento" placeholder="">
                </div>
                <div class="form-group col-lg-4 col-md-4 col-sm-12 mb-8">
                    <label for="">Bairro</label>
                    <input type="text" class="form-control  @error('bairro') is-invalid @enderror" wire:model.lazy="bairro" wire:blur="bairroUpper()"
                        placeholder="...">
                    @if($errors->get('bairro'))
                            <p class="text-danger">O Bairro é obrigatório.</p>
                    @endif
                </div>
                <div class="form-group col-lg-4 col-md-4 col-sm-8 mb-8">
                    <label for="">Cidade</label>
                    <input type="text" class="form-control  @error('localidade') is-invalid @enderror" wire:model.lazy="localidade" wire:blur="cidadeUpper()"
                        placeholder="...">
                        @if($errors->get('localidade'))
                            <p class="text-danger">O Campo Cidade é obrigatório.</p>
                        @endif
                </div>
                <div class="form-group col-lg-1 col-md-1 col-sm-4 mb-8">
                    <label for="">UF</label>
                    <input type="text" class="form-control  @error('uf') is-invalid @enderror" wire:model.lazy="uf" wire:blur="ufUpper()"
                        placeholder="...">
                        @if($errors->get('uf'))
                            <p class="text-danger">O Estado é obrigatório.</p>
                        @endif
                </div>
                <div class="form-group col-lg-4 col-md-4 col-sm-12 mb-8">
                    <label for="">telefone</label>
                    <input type="tel" class="form-control" wire:blur="telefone()" wire:model.lazy="telefone" placeholder="Ex.: (00) 99999999">
                </div>
                <div class="form-group col-lg-4 col-md-4 col-sm-12 mb-8">
                    <label for="">celular</label>
                    <input type="tel" class="form-control" wire:blur="cel1()" wire:model.lazy="celular1" placeholder="Ex.: (00) 99999999">
                </div>
                <div class="form-group col-lg-4 col-md-4 col-sm-12 mb-8">
                    <label for="">celular</label>
                    <input type="tel" class="form-control" wire:blur="cel2()" wire:model.lazy="celular2" placeholder="Ex.: (00) 99999999">
                </div>

            </div>
            <div class="row">
                <div class="col-md-12">
                <hr />
                    <h3>Dados do Falecido</h3>
                    <hr />
                </div>

                <div class="form-group col-lg-2 col-md-2 col-sm-4">
                    <label for="">QUADRA</label>
                    <input type="text" wire:keydown.enter='testaQuadra()' wire:model.lazy="quadra" class="form-control text-center  @error('quadra') is-invalid @enderror" maxlength="6"
                        placeholder="Ex.: 999999" autofocus>
                    @if($errors->get('quadra'))
                            <p class="text-danger">Número da Quadra é obrigatório.</p>
                    @endif
                </div>
                <div class="form-group col-lg-2 col-md-2 col-sm-8">
                    <label>NÚMERO</label>
                    <input type="number" wire:keydown.enter='buscaNumero()' wire:blur='buscaNumero()' wire:model="numero" class="form-control text-center  @error('numero') is-invalid @enderror">
                    @if($errors->get('numero'))
                        <p class="text-danger">O Número da sepultura é obrigatório.</p>
                    @endif
                </div>

                <div class="form-group col-lg-4 col-md-4 col-sm-6 mb-8">
                    <label for="">CEMITÉRIO</label><br>
                    <div class="input-group">
                        <select wire:model.lazy="cemiterio_id" class="form-control @error('cemiterio_id') is-invalid @enderror">
                            <option value="Escolha" disabled>Escolha</option>
                            @foreach($cemiterios as $ce)
                            <option value="{{$ce->id}}">{{$ce->nome}}</option>
                            @endforeach

                        </select>
                        <div class="input-group-prepend">

                            <a class="text-dark input-group-text" wire:click="createShowModal(1)" type="button">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-circle"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>
                            </a>

                        </div>
                        @if($errors->get('cemiterio_id'))
                                <p class="text-danger">Escolha o Cemitério.</p>
                        @endif
                    </div>

                </div>

                <div class="form-group col-lg-2 col-md-2 col-sm-4">
                    <label for="">LATITUDE</label>
                    <input type="text" class="form-control" wire:model.lazy="latitude" >
                </div>
                <div class="form-group col-lg-2 col-md-2 col-sm-4">
                    <label for="">LONGITUDE</label>
                    <input type="text" class="form-control" wire:model.lazy="longitude" >
                </div>

                <div class="form-group col-lg-5 col-md-5 col-sm-12 mb-8">
                    <label for="">NOME</label>
                    <input type="text" class="form-control @error('nomePessoa') is-invalid @enderror" wire:blur="nomeUpper()" wire:model.lazy="nomePessoa"
                        placeholder="Nome do Falecido" maxlenght="80">

                    @if($errors->get('nomePessoa'))
                            <p class="text-danger">Nome do Falecido é obrigatório.</p>
                    @endif
                </div>
                <div class="form-group col-lg-2 col-md-2 col-sm-12 mb-8">
                    <label for="">Idade</label>
                    <input type="text" class="form-control" wire:model.lazy="idade" placeholder="Idade">
                </div>

                <div class="form-group col-lg-5 col-md-5 col-sm-12 mb-8">
                    <label for="">MÃE</label>
                    <input type="text" class="form-control" wire:model.lazy="mae" wire:keyup="maeUpper()"
                        placeholder="...">
                </div>

                <div class="form-group col-lg-3 col-md-3 col-sm-12 mb-8">
                    <label for="">Data Óbito</label>
                    <input type="date" class="form-control @error('dt_obito') is-invalid @enderror" wire:model.lazy="dt_obito">
                    @if($errors->get('dt_obito'))
                            <p class="text-danger">Digite a data do óbito.</p>
                    @endif
                </div>
                <div class="form-group col-lg-3 col-md-3 col-sm-12 mb-8">
                    <label for="">Data Sepultamento</label>
                    <input type="date" class="form-control @error('dt_sepultamento') is-invalid @enderror" wire:model.lazy="dt_sepultamento">
                    @if($errors->get('dt_sepultamento'))
                            <p class="text-danger">Data do sepultamento é obrigatório.</p>
                    @endif
                </div>

                <div class="form-group col-lg-3 col-md-3 col-sm-12 mb-8">
                    <label for="">Hora</label>
                    <input type="time" class="form-control" wire:model.lazy="hora_sepultamento">
                </div>

                <div class="form-group col-lg-3 col-md-3 col-sm-12 mb-8">
                    <label for="">CPF/CNPJ Cliente</label>
                    <input type="text" class="form-control" wire:model.lazy="cpf_cliente" readonly>
                </div>

                <div class="form-group col-lg-4 col-md-4 col-sm-6 mb-8">
                    <label for="">FUNERÁRIA</label><br>
                    <div class="input-group">
                        <select wire:model.lazy="funeraria_id" class="form-control @error('funeraria_id') is-invalid @enderror">
                            <option value="Escolha" disabled>Escolha</option>
                            @foreach($funerarias as $f)
                            <option value="{{$f->id}}">{{$f->nome}}</option>
                            @endforeach

                        </select>
                        <div class="input-group-prepend">

                            <a class="text-dark input-group-text" wire:click="createShowModal(2)" type="button" id="dropdownMenuButton" aria-haspopup="true" aria-expanded="false">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-circle"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>
                            </a>

                        </div>
                    </div>
                    @if($errors->get('funeraria_id'))
                            <p class="text-danger">Escolha a Funerária.</p>
                    @endif
                </div>

                <div class="form-group col-lg-3 col-md-3 col-sm-4 mb-8">
                    <label for="">TIPO SEPULTURA</label><br>
                    <div class="input-group">
                        <select wire:model.lazy="tp_sepultura" class="form-control @error('tp_sepultura') is-invalid @enderror">
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
                    @if($errors->get('tp_sepultura'))
                            <p class="text-danger">Tipo de Sepultura é obrigatório.</p>
                    @endif
                </div>
                <div class="form-group col-lg-5 col-md-5 col-sm-8 mb-8">
                    <label for="">TAXA REFERENTE A</label><br>
                    <div class="input-group">
                        <select wire:model.lazy="taxa_id" wire:change="preencheObs()" class="form-control @error('taxa_id') is-invalid @enderror">
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
                            <p class="text-danger">Taxa de referência é obrigatório.</p>
                    @endif
                </div>


                <div class="form-group col-lg-6 col-md-6 col-sm-12 mb-8">
                    <label for="">Observação</label>
                    {{-- <x-jet-label for="title" value="{{_('Observação')}}" /> --}}

                    <div class="roundedmd shadow-sm">
                        <div class="mt-1 bg-white">
                            <div class="body-content" wire:ignore>
                                <trix-editor class="trix-content" x-ref="trix" wire:model.debounce.100000ms="obs" wire:key="trix-content-unique-key">

                                </trix-editor>
                            </div>
                        </div>
                    </div>
                    
                    
                </div>


            </div>
            <div class="row">
                <button type="button" wire:click="doAction(1)" class="btn btn-dark mr-1">
                    <i class="mbri-left"></i> Voltar
                </button>
                <button type="button" wire:click.prevent="StoreOrUpdate()" class="btn btn-primary">
                    <i class="mbri-success"></i> Salvar
                </button>
            </div>

        </form>
 {{--       <div class="row justify-content-center">
            <div class="col-md-8 col-md-offset-2" align="center">
                <h4>Localização</h4>
                <div style="text-align: left;margin-top: 30px;">
                    <b>Latitude: </b><span id="latitude"></span><br>
                    <b>Longitude: </b><span id="longitude"></span><br>
                    <b>Country: </b><span id="country"></span><br>
                    <b>City: </b><span id="city"></span><br>
                    <b>Continent: </b><span id="continent"></span><br>
                </div>
                <div id="map">
                    <iframe 
                    width="450"
                    height="300"
                    frameborder="0" style="border:0; width: 450;"
                    src="" allowfullscreen>
                    </iframe>
                </div>
            </div>
        </div>--}}
        @include('livewire.requerimento.modalcemiterio')

        @include('livewire.requerimento.modalfuneraria')

        @include('livewire.requerimento.modaltiposepultura')
        
        @include('livewire.requerimento.modaltaxa')

    </div>

</div>

<script>
    $(document).ready(function() {
        if ("geolocation" in navigator) {
            navigator.geolocation.getCurrentPosition(function (p){
                showUserDetails(p.coords.latitude, p.coords.longitude);
            }, function (e) {
                ipLookup();
            })
        } else
            ipLookup();        
        
    })

    function showUserDetails(latitude, longitude, additional) {    
        var position = "-18.990731, -49.485765";//latitude + "," + longitude;

        $("#latitude").text(latitude);
        $("#longitude").text(longitude);

        var url = "https://www.google.com/maps/embed/v1/view?key=AIzaSyBsx03RimZ8OqThSsxvz2ElSUMlz8bPfEQ&center="+position+"&zoom=16&maptype=satellite";
        $("iframe").attr('src', url);

        if (typeof additional != "undefined") {
            $("#country").text(additional.country.name);
            $("#city").text(additional.city.name);
            $("#continent").text(additional.continent.name);
        }
    }

    function ipLookup() {
        $.get('https://api.userinfo.io/userinfos', function (r) {
            showUserDetails(r.position.latitude, r.position.longitude, r); 
        });
    }
    
</script>
