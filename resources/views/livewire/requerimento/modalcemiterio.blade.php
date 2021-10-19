<!-- Modal -->
<x-jet-dialog-modal wire:model="modalFormVisible">
  <x-slot name="title">
      {{ __('Novo Cemitério') }}
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
          <x-jet-label for="cnome" value="{{ __('Cemitério') }}" />
          <x-jet-input id="cnome" class="block mt-1 w-full" type="text" wire:model.debounce.800ms="cnome"/>
          @error('cnome')
              <span class="error">{{$message}}</span>
          @enderror
      </div>

  </x-slot>

  <x-slot name="footer">
      <x-jet-secondary-button wire:click="$toggle('modalFormVisible')" wire:loading.attr="disabled">
          {{ __('Fechar') }}
      </x-jet-secondary-button>

      <x-jet-button class="ml-2" wire:click="createCemiterio" wire:loading.attr="disabled">
          {{ __('Salvar') }}
      </x-jet-button>
  </x-slot>
</x-jet-dialog-modal>
