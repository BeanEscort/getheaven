@extends('layouts.appmain')

@section('content')

<h1>Cadastrar nova empresa</h1> 

<form action="{{ route('empresas.store') }}" method="post">
    @include('companies._partials.form')
</form>

@endsection