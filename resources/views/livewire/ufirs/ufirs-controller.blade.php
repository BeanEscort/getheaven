<div class="widget-content-area">
	<div class="widget-one">
		<div class="row">
			 @include('common.alerts')
			 @include('common.messages') 
			<div class="col-12">
				<h4 class="text-center">Atualizando UFIR</h4>
			</div>
			<div class="form-group col-sm-4 col-lg-4 col-md-4">
				<label >Ano</label>
				<input wire:model.lazy="ano" type="number" class="form-control" autofocus>				 
			</div>
			
			<div class="form-group col-lg-4 col-md-4 col-sm-4">
				<label >Valor</label>
				<input type="number" wire:model.lazy='valor_ufir' class="form-control text-right">
			</div>
			<div class="form-group col-sm-4 col-lg-4 col-md-4">
				<label >Valor Anterior</label>
				<input wire:model.lazy="valor_anterior" type="number" class="form-control text-right" readonly >
			</div>
			<div class="col-12">
				<button type="button"
				wire:click="Guardar()"
				class="btn btn-primary ml-2">
				<i class="mbri-success"></i> Salvar
				</button>
			</div>
		</div>
	</div>
</div>