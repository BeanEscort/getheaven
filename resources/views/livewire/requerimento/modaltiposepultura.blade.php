<!-- Modal -->
<x-jet-dialog-modal wire:model="modalTipoVisible">
    <x-slot name="title">
        {{ __('Tipos de Sepultura') }}
    </x-slot>

    <x-slot name="content">
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

        <div class="mt-4">
            <x-jet-label for="tipo" value="{{ __('Tipo Sepultura') }}" />
            <x-jet-input id="tipo" class="block mt-1 w-full" type="text" wire:model.debounce.800ms="tipo"/>
            @error('tipo')
                <span class="error">{{$message}}</span>
            @enderror
        </div>

    </x-slot>

    <x-slot name="footer">
        <x-jet-secondary-button wire:click="$toggle('modalTipoVisible')" wire:loading.attr="disabled">
            {{ __('Fechar') }}
        </x-jet-secondary-button>

        <x-jet-button class="ml-2" wire:click="createTipo()" wire:loading.attr="disabled">
            {{ __('Salvar') }}
        </x-jet-button>
    </x-slot>
  </x-jet-dialog-modal>
