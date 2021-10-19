<!-- Modal -->
<x-jet-dialog-modal wire:model="modalFunerariaVisible">
    <x-slot name="title">
        {{ __('Nova Funerária') }}
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
            <x-jet-label for="fnome" value="{{ __('Funerária') }}" />
            <x-jet-input id="fnome" class="block mt-1 w-full" type="text" wire:model.debounce.800ms="fnome"/>
            @error('fnome')
                <span class="error">{{$message}}</span>
            @enderror
        </div>

    </x-slot>

    <x-slot name="footer">
        <x-jet-secondary-button wire:click="$toggle('modalFunerariaVisible')" wire:loading.attr="disabled">
            {{ __('Fechar') }}
        </x-jet-secondary-button>

        <x-jet-button class="ml-2" wire:click="createFuneraria" wire:loading.attr="disabled">
            {{ __('Salvar') }}
        </x-jet-button>
    </x-slot>
  </x-jet-dialog-modal>
