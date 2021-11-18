<div class="p-6">

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

    <div class="flex flex-col">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
 
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Nome</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Domínio</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Banco de Dados</th>
                                <th class="px-6 py-3 bg-gray-50 text-right text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                    <x-jet-button class="btn-info" wire:click="createShowModal">
                                        {{ __('Criar Empresa') }}
                                    </x-jet-button>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @if ($data->count())
                                @foreach($data as $item)

                                <tr>
                                    <td class="px-6 py-4 text-sm whitespace-no-wrap">{{ $item->name}}</td>
                                    <td class="px-6 py-4 text-sm whitespace-no-wrap">
                                        <a class="text-indigo-600 hover:text-indigo-900"
                                            target="_blank"
                                            href="{{'http://'.$item->domain.'/'}}">
                                            {{ $item->domain }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 text-sm whitespace-no-wrap">{{ $item->database }}</td>
                                    <td class="px-6 py-4 text-right text-sm">
                                        <x-jet-button wire:click="updateShowModal({{ $item->id }})">
                                            {{ __('Alterar') }}
                                        </x-jet-button>
                                        @if($item->database !== 'tenancy')
                                            <x-jet-danger-button wire:click="deleteShowModal({{ $item->id }})">
                                                {{ __('Excluir') }}
                                            </x-jet-danger-button>
                                        @endif
                                    </td>
                                </tr>

                                @endforeach
                            @else
                                <tr>
                                    <td class="px-6 py-4 text-sm whitespace-no-wrap" colspan="4">Nenhum Registro Encontrado!</td>
                                </tr>
                            @endif

                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
    <br/>

    {{ $data->links()}}

    <x-jet-dialog-modal wire:model="modalFormVisible">
        <x-slot name="title">
            @if ($modelId)
                {{ __('Alterar') }}
            @else
                {{ __('Nova Empresa') }}
            @endif
        <div>
            @if (session()->has('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif
        </div>
        <div>
            @if (session()->has('erro'))
                <div class="alert alert-danger">
                    {{ session('erro') }}
                </div>
            @endif
        </div>
        </x-slot>

        <x-slot name="content">
        <div class="row mt-3" style="border-style: ridge; border-color: sian;">


            <div class="form-group col-lg-8 col-md-8 col-sm-12">
                <x-jet-label for="name" value="{{ __('Nome da Empresa') }}" />
		@error('name')
                    <span class="error">{{$message}}</span>
                @enderror
                <x-jet-input id="name" class="form-control block mt-1 w-full" type="text" wire:model.debounce.800ms="name"/>
            </div>

            <div class="form-group col-lg-4 col-md-4 col-sm-12">
                <x-jet-label for="cnpj" value="{{ __('CNPJ') }}" />
                <x-jet-input wire:keydown.enter="testaCNPJ()" wire:blur="testaCNPJ()" id="cnpj" class="form-control block mt-1 w-full" type="text" wire:model="cnpj" />
                @error('cnpj')
                    <span class="error">{{$message}}</span>
                @enderror
            </div>
            <div class="mt-1 form-group col-lg-12 col-md-12 col-sm-12">
                <x-jet-label for="domain" value="{{ __('Domínio') }}" />
                <div class="mt-1 flex rounded-md shadow-sm">
                    <span class="inline-flex items-center px-3 rounded-1-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                        http://
                    </span>
                    <input wire:model="domain" type="text" class="form-control flex-1 block w-full rounded-none rounded-r-md transition duration-150 ease-in-out sm:text-sm sm:leading-5" placeholder="url-domain">
                    <span class="inline-flex items-center px-3 rounded-1-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                        getheaven.com.br
                    </span>
                </div>
                @error('domain')
                    <span class="error">{{$message}}</span>
                @enderror
            </div>

            <div class="mt-1 form-group col-lg-6 col-md-6 col-sm-12">
                <x-jet-label for="database" value="{{ __('Banco de Dados') }}" />

                <x-jet-input id="database" class="form-control block mt-1 w-full" type="text" wire:model.debounce.800ms="database"/>
                @error('database')
                    <span class="error">{{$message}}</span>
                @enderror
            </div>

            <div class="mt-1 form-group col-lg-6 col-md-6 col-sm-12">
                <x-jet-label for="contato" value="{{ __('Contato') }}" />
                <x-jet-input id="contato" class="form-control block mt-1 w-full" type="text" wire:model.debounce.800ms="contato"/>
                @error('contato')
                    <span class="error">{{$message}}</span>
                @enderror
            </div>

            <div class="mt-1 form-group col-lg-6 col-md-6 col-sm-12">
                <x-jet-label for="telefone_fixo" value="{{ __('Telefone') }}" />
                <x-jet-input id="telefone_fixo" class="form-control block mt-1 w-full" type="text" wire:model.debounce.800ms="telefone_fixo"/>
                @error('telefone_fixo')
                    <span class="error">{{$message}}</span>
                @enderror
            </div>

            <div class="mt-1 form-group col-lg-6 col-md-6 col-sm-12">
                <x-jet-label for="orgao_responsavel" value="{{ __('Orgão Resposável') }}" />
                <x-jet-input id="orgao_responsavel" class="form-control block mt-1 w-full" type="text" wire:model.debounce.800ms="orgao_responsavel"/>
                @error('orgao_responsavel')
                    <span class="error">{{$message}}</span>
                @enderror
            </div>
            <div class="mt-1 form-group col-lg-6 col-md-6 col-sm-12">
                <x-jet-label value="{{ __('UF') }}" />
                <select id="state_id" name="state_id" wire:change="changeCity()" wire:model.lazy="state_id" class="form-control  block mt-1 w-full">
                    <option value="Escolha">...</option>
                    @foreach($states as $s)
                    <option value="{{$s ->id}}">{{$s->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="mt-1 form-group col-lg-6 col-md-6 col-sm-12">
                <x-jet-label value="{{ __('Cidade') }}" />
                <select  wire:model.debounce.800ms="city_id" class="form-control  block mt-1 w-full">
                    <option value="Escolha">...</option>
                    @foreach($cities as $c)
                    <option value="{{$c->id}}">{{$c->name}}</option>
                    @endforeach
                </select>

            </div>

	    <div class="mt-1 form-group col-lg-12 col-md-12 col-sm-12">
                <x-jet-label for="logo" value="{{ __('Logo da Empresa') }}" />
		@error('logo')
                	<span class="error">{{$message}}</span>
                @enderror
		<div class="mt-1 flex rounded-md shadow-sm">
	                <x-jet-input id="logo" class="form-control block mt-1 w-full" type="file" wire:model="logo" />
            	</div>
            </div>
	</div>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('modalFormVisible')" wire:loading.attr="disabled">
                {{ __('Cancelar') }}
            </x-jet-secondary-button>
            @if($modelId)
                <x-jet-button class="ml-2" wire:click="update" wire:loading.attr="enabled">
                    <div class="ml-4" wire:loading wire:target="update">
                        <x-loading />
                    </div>
                    {{ __('Atualizar') }}

                </x-jet-button>
            @else
                <x-jet-button name="criar" class="ml-2" wire:click="create" wire:loading.attr="enabled">
                    <div class="mr-4" wire:loading wire:target="create">
                        <x-loading />
                    </div>
                    {{ __('Criar') }}

                </x-jet-button>

            @endif
        </x-slot>
    </x-jet-dialog-modal>
    <!-- Delete User Confirmation Modal -->
    <x-jet-dialog-modal wire:model="modalConfirmDeleteVisible">
        <x-slot name="title">
            {{ __('Excluir Empresa') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Tem certeza que deseja excluir essa Empresa? Depois que a Empresa for excluída, todos os seus recursos e dados serão excluídos permanentemente.') }}

        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('modalConfirmDeleteVisible')" wire:loading.attr="disabled">
                {{ __('Cancelar') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-2" wire:click="delete" wire:loading.attr="disabled">
                <div class="mr-4" wire:loading wire:target="delete">
                    <x-loading />
                </div>
                {{ __('Excluir Empresa') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-dialog-modal>

    <x-jet-dialog-modal wire:model="loadingVisible">
        <x-slot name="title">

        </x-slot>

        <x-slot name="content">

            <div  wire:model="loadingVisible" style="position: relative; z-index: 10;"> <div style=" background-color: #none; position:absolute; z-index:-1; top:0; left:0; right: 0; bottom:0; opacity:0.2;"></div>
                <div class="la-ball-clip-rotate-pulse la-dark la-3x">
                    <div></div>
                    <div></div>
                </div>
            </div>

        </x-slot>

        <x-slot name="footer">

        </x-slot>
    </x-jet-dialog-modal>
</div>
