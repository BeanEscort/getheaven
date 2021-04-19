@extends('layouts.appmain')

@section('content')

<h1>Detalhes da empresa <b>{{ $company->name }}</b></h1>

<ul>
    <li><strong>Nome:</strong> {{ $company->name }}</li>
    <li><strong>Domínio:</strong> {{ $company->domain }}</li>
    <li><strong>Database:</strong> {{ $company->database }}</li>
    
</ul>

<hr>

<form action="{{ route('empresas.destroy', $company->id) }}" method="post">
    @csrf

    <input type="hidden" name="_method" value="DELETE">

    <button type="submit" class="btn btn-danger">Deletar Empresa: {{ $company->name }}</button>
</form>


@endsection