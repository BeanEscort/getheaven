<!-- Modal -->
<x-jet-dialog-modal wire:model="modalTaxaVisible">
    <x-slot name="title">
        {{ __('Taxas') }}
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
            <x-jet-label for="tipotaxa" value="{{ __('Tipo de Taxa') }}" />
            <x-jet-input id="tipotaxa" class="block mt-1 w-full" type="text" wire:model.debounce.800ms="tipotaxa"/>
            @error('tipotaxa')
                <span class="error">{{$message}}</span>
            @enderror
        </div>
        <div class="row mt-4">
            <div class="col-md-6">
                <x-jet-label for="total_ufir" value="{{ __('Total de UFIRs') }}" />
                <x-jet-input id="total_ufir" class="block mt-1 w-full" type="text" wire:blur="updateValor()" wire:model.debounce.800ms="total_ufir"/>
                @error('total_ufir')
                    <span class="error">{{$message}}</span>
                @enderror
            </div>
            <div class="col-md-6">
                <x-jet-label for="valor_taxa" value="{{ __('Valor da Taxa') }}" />
                <x-jet-input id="valor_taxa" class="block mt-1 w-full" type="text" wire:model.debounce.800ms="valor_taxa" disabled/>
                @error('valor_taxa')
                    <span class="error">{{$message}}</span>
                @enderror
            </div>
        </div>

    </x-slot>

    <x-slot name="footer">
        <x-jet-secondary-button wire:click="$toggle('modalTaxaVisible')" wire:loading.attr="disabled">
            {{ __('Fechar') }}
        </x-jet-secondary-button>

        <x-jet-button class="ml-2" wire:click="createTaxa()" wire:loading.attr="disabled">
            {{ __('Salvar') }}
        </x-jet-button>
    </x-slot>
  </x-jet-dialog-modal>
