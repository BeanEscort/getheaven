@extends('layouts.appmain')

@section('content')

<h1>
    Empresas
    <a href="{{ route('empresas.create') }}" class="btn btn-outline-primary btn-sm" role="button">
        <i class="fas fa-plus-square">Novo</i>
    </a>
</h1>

@include('includes.alerts')

<ul class="media-list">
    @forelse($companies as $company)
    <li class="media">
        <div class="media-body">
            <span class="text-muted pull-right">
                <small class="text-muted">{{ $company->created_at->format('d/m/Y') }}</small>
            </span>
            <strong class="text-success">{{ $company->domain }}</strong>
            <p>
                {{ $company->name }}
                <br>
                <a href="{{ route('empresas.show', $company->domain) }}">Detalhes</a> |
                <a href="{{ route('empresas.edit', $company->domain) }}">Editar</a>
            </p>
        </div>
    </li>
    <hr>
    @empty
    <li class="media">
        <p>Nenhuma empresa cadastrada!</p>
    </li>
    @endforelse

    {!! $companies->links() !!}
</ul>

@endsection