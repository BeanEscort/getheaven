 <div class="widget-content-area ">
 	<div class="widget-one">
 		<form>
 			@include('common.messages')        

 			<div class="row">
 				<div class="form-group col-lg-4 col-md-4 col-sm-12">
 					<label >Nome</label>
 					<input wire:model.lazy="name" type="text" class="form-control"  placeholder="Nome do Usuário">
 				</div> 				
 				
 				<div class="form-group col-lg-4 col-md-4 col-sm-12"> 					
 					<label >Email</label>
 					<input wire:model.lazy="email" type="text" class="form-control"  placeholder="correio@gmail.com"> 			
 				</div>
 				<div class="form-group col-lg-4 col-md-4 col-sm-12">
 					@if(auth()->user()->tipo === 'Admin')
					<label >Função</label>
 					<select wire:model="tipo" class="form-control text-center">
 						<option value="Escolha" disabled="">Escolha</option>                         
 						<option value="Admin">Admin</option>                         
 						<option value="Gerente">Gerente</option>                         
 						<option value="Usuário">Usuário</option>                         
 					</select>			   
					@endif            
 				</div>
 				<div class="form-group col-lg-4 col-md-4 col-sm-12"> 					
 					<label >Password</label>
 					<input wire:model.lazy="password" type="password" class="form-control"  placeholder="senha"> 			
 				</div>
 				
 				
 			</div>
 			<div class="row ">
 				<div class="col-lg-5 mt-2  text-left">
 					<button type="button" wire:click="doAction(1)" class="btn btn-dark mr-1">
 						<i class="mbri-left"></i> Voltar
 					</button>
 					<button type="button"
 					wire:click="StoreOrUpdate() " 
 					class="btn btn-primary ml-2">
 					<i class="mbri-success"></i> Salvar
 				</button>
 			</div>
 		</div>
 	</form>
 </div>
</div>

<script>
window.livewire.on('fileChoosen', ()=>{
	let inputField = document.getElementById('novoavatar')
	
	let file = inputField.files[0]
	let reader = new FileReader();

	reader.onloadend = ()=>{
		window.livewire.emit('avatarUpload', reader.result)
	}
	reader.readAsDataURL(file);
})
</script>
