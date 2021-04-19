@extends('layouts.appmain')

@section('content')

<h1>Detalhes da empresa <b>{{ $company->name }}</b></h1>

<form action="{{ route('empresas.update', $company->id) }}" method="post">
    <input type="hidden" name="_method" value="PUT">

    @include('companies._partials.form')
</form>

@endsection