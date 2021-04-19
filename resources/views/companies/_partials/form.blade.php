@include('includes.alerts')

@csrf

<div class="form-group">
    <input value="{{ isset($company)?$company->name : old('name') }}" class="form-control" type="text" name="name" placeholder="Nome:">
</div>
<div class="form-group">
    <input value="{{ isset($company)?$company->domain : old('domain') }}" class="form-control" type="text" name="domain" placeholder="Domínio:">
</div>
<div class="form-group">
    <input value="{{ isset($company)?$company->database : old('database') }}" class="form-control" type="text" name="database" placeholder="Database:">
</div>

 @if (!isset($company))
<div class="form-group">
    <label for="create_database">
        <input type="checkbox" name="create_database" checked>
        Criar banco de dados?
    </label>
</div>
@endif

<div class="form-group">
    <button type="submit" class="btn btn-success">Enviar</button>
</div>