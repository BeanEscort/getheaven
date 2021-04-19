<div class="widget-content-area">
    <div class="widget-one">
        <form action="">
            <h3>Criar / Editar Clientes</h3>
            @include('common.messages')
            <div class="row">
                <div class="form-group col-lg-3 col-md-3 col-sm-12">
                    <label for="">CPF/CNPJ</label>
                    <input type="text" wire:keydown.enter="buscaCPF()" wire:model="cpf" class="form-control text-center" maxlength="20" placeholder="Ex.: 99999999999"  autofocus>
                </div>
                <div class="form-group col-lg-3 col-md-3 col-sm-12">
                    <label>Data</label>
                    <input type="date" wire:model="data_cadastro" class="form-control text-center">
                </div>
                <div class="form-group col-lg-6 col-md-6 col-sm-12">
                    <label for="">Nome do Cliente</label>
                    <input type="text" class="form-control" wire:model.lazy="nome" wire:blur="nomeUpper()">
                </div>
                <div class="form-group col-lg-3 col-md-3 col-sm-12 mb-8">
                    <label for="">CEP</label>
                    
                    <input type="text" name="cep" id="" value="" wire:keydown.enter="buscaCep()" wire:model="cep" class="form-control" placeholder="Ex.: 99999999" maxlenght="10">
                </div>
                <div class="form-group col-lg-6 col-sm-12 mb-8">
                    <label for="">Endereço</label>
                    <input type="text" value="" name="logradouro" id="logradouro" class="form-control" wire:model.lazy="logradouro" wire:blur="enderecoUpper()" placeholder="...">
                </div>
                <div class="form-group col-lg-3 col-md-3 col-sm-12 mb-8">
                    <label for="">Nro</label>
                    <input type="text" class="form-control" wire:model.lazy="nro" placeholder="...">
                </div>
                <div class="form-group col-lg-3 col-md-3 col-sm-12 mb-8">
                    <label for="">Complemento</label>
                    <input type="text" id="complemento" class="form-control" wire:model.lazy="complemento" placeholder="">
                </div>
                <div class="form-group col-lg-4 col-md-4 col-sm-12 mb-8">
                    <label for="">Bairro</label>
                    <input type="text" value="" name="bairro" id="bairro" class="form-control" wire:model.lazy="bairro" wire:blur="bairroUpper()" placeholder="...">
                </div>
                <div class="form-group col-lg-4 col-md-4 col-sm-8 mb-8">
                    <label for="">Cidade</label>
                    <input type="text" name="localidade" id="localidade" class="form-control" wire:model.lazy="localidade" wire:blur="cidadeUpper()" placeholder="...">
                </div>
                <div class="form-group col-lg-1 col-md-1 col-sm-4 mb-8">
                    <label for="">UF</label>
                    <input type="text" value="" name="uf" id="uf" class="form-control" wire:model.lazy="uf" wire:blur="ufUpper()" placeholder="...">
                </div>
                <div class="form-group col-lg-4 col-md-4 col-sm-12 mb-8">
                    <label for="">telefone</label>
                    <input type="tel" class="form-control" wire:model.lazy="telefone" placeholder="Ex.: (00) 99999999">
                </div>
                <div class="form-group col-lg-4 col-md-4 col-sm-12 mb-8">
                    <label for="">celular</label>
                    <input type="tel" class="form-control" wire:model.lazy="celular1" placeholder="Ex.: (00) 99999999">
                </div>
                <div class="form-group col-lg-4 col-md-4 col-sm-12 mb-8">
                    <label for="">celular</label>
                    <input type="tel" class="form-control" wire:model.lazy="celular2" placeholder="Ex.: (00) 99999999">
                </div>

            </div>
            <div class="row">
                <button type="button" wire:click="doAction(1)" class="btn btn-dark mr-1">
                <i class="mbri-left"></i> Voltar
                </button>
                <button type="button"
                wire:click.prevent="StoreOrUpdate() "
                class="btn btn-primary">
                <i class="mbri-success"></i> Salvar
                </button>
            </div>
        </form>
    </div>
</div>
