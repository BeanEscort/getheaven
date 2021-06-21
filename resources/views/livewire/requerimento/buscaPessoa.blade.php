<section id="buscaPessoa">
	<div class="row layout-top-spacing">
		<div class="col-2"></div>
		<div class="col-xl-10 col-lg-10 col-md-10 layout-spacing" x-data="{isOpen:true}" @click.away="isOpen = false">
			<div class="widget-content-area br-4">
				<div class="widget-one">
					<div class="row">
						@include('common.messages')
						<div class="col-2">
							<button class="btn btn-dark" wire:click.prevent="Voltar()"><i class="la la-chevron-left"></i></button>
						</div>
						<div class="col-8">
							<h5 class="text-center"><b>BUSCA PESSOA</b></h5>
						</div>
						<div class="col-2 text-right">
							<label id="tc"></label>
						</div>
					</div>
					
					<div class="row mt-3" x-data="{ isOpen : true }" @click.away="isOpen = false">
						<div class="col-md-12 ml-auto"> 
							<div class="input-group mb-2 mr-sm-2">
								<div class="input-group-prepend">
									<div class="input-group-text"><i class="la la-search"></i></div>
								</div>
								<input type="text" class="form-control" placeholder="buscar por NOME ou NÚMERO da SEPULTURA"
								wire:model.lazy="buscarPessoa"
								@focus="isOpen = true"
								@keydown.escape.tab="isOpen = false"
								@keydown.shift.tab="isOpen = false"
								>
								<div class="input-group-prepend">
									<div class="input-group-text"><i wire:click.prevent="limparPessoa()" class="la la-trash la-lg"></i></div>
								</div>
							</div>
							<ul class="list-group" x-show.transition.opacity="isOpen">
								@if($buscarPessoa != '')
								@foreach($pessoas as $r)
								<li wire:click="mostrarPessoa('{{$r}}')" class="list-group list-group-item-action">
									<b>{{$r->nome}}</b> - Quadra: {{$r->quadra}} - Número: {{ $r->numero}} - Falecido em: {{ date_format($r->dt_obito,'d-m-Y')}} - Cemitério: {{ $r->cemiterio($r->cemiterio_id) }}
								</li>
								@endforeach
								@endif
							</ul>
						</div>
					</div>
					
					<div class="row">
						<h5>Dados da Pessoa</h5><br>
					</div>
						<div class="row">
							<div class="form-group col-lg-8 col-md-8 col-sm-12">
								<h7 class="text-info">Nome</h7>
								<div class="input-group mb-2-sm-2">
									<div class="input-group-prepend">
										<div class="input-group-text"><i class="la la-user la-lg"></i></div>
									</div>
									<input type="text" class="form-control" wire:model.lazy="nome" maxlength="30">
								</div>
							</div>
						
							<div class="form-group col-lg-4 col-md-4 col-sm-12">
                                                        	<h7 class="text-info">Falecido em</h7>
                                                        	<div class="input-group mb-2-sm-2">
                                                                	<div class="input-group-prepend">
                                                                        	<div class="input-group-text"><i class="la la-calendar la-lg"></i></div>
                                                                	</div>
                                                                	<input type="text" class="form-control" wire:model.lazy="data_obito">
                                                        	</div>
                                                	</div>
						</div>
						<div class="row">
							<div class="form-group col-lg-3 col-md-6 col-sm-12">
								<h7 class="text-info">Quadra</h7>
								<div class="input-group mb-2-sm-2">
									<div class="input-group-prepend">
										<div class="input-group-text"><i class="la la-pencil la-lg"></i></div>
									</div>
									<input type="text" class="form-control" wire:model.lazy="quadra" maxlength="6">
								</div>
							</div>
						
							<div class="form-group col-lg-3 col-md-6 col-sm-12">
								<h7 class="text-info">Número</h7>
								<div class="input-group mb-2-sm-2">
									<div class="input-group-prepend">
										<div class="input-group-text"><i class="la la-pencil la-lg"></i></div>
									</div>
									<input type="number" class="form-control" wire:model.lazy="numero" maxlength="6">
								</div>
							</div>
						
							<div class="form-group col-lg-6 col-md-12 col-sm-12">
								<h7 class="text-info">Cemitério</h7>
								<div class="input-group mb-2-sm-2">
									<div class="input-group-prepend">
										<div class="input-group-text"><i class="la la-home la-lg"></i></div>
									</div>
									<input type="text" class="form-control" wire:model.lazy="cnome">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4 col-lg-4 col-sm-6">
								@if($numero > 0)
									<button wire:click.prevent="$set('action', 2)" class="btn btn-success mt-4">Transportar Dados</button>
								@endif
							</div>
						</div>
				</div>

			</div>
		</div>
		<!-- <div class="col-2"></div> -->
	</div>
</section>
