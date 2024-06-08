@extends('layouts.admin')

@section('content')
    <h2>Singolo progetto</h2>
    {{-- messaggio flash --}}
    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        
        {{-- nome progetto --}}
        <div class="card-body">
            <h5 class="card-title">{{$project->name}}</h5>
        </div>

        {{-- immagine --}}
        @if($project->cover_image)
            <div class="card-body">
                <img src="{{ asset('storage/' . $project->cover_image )}}" alt="{{$project->name}}">
            </div>
        @endif
        
        {{-- corpo progetto --}}
        <ul class="list-group list-group-flush">

            {{-- Tipo --}}
            <li class="list-group-item">
                <strong>Tipo</strong>:
                {{$project->type ? $project->type->name : 'Nessuno'}}
            </li>

            {{-- Slug --}}
            <li class="list-group-item">
                <strong>Slug</strong>:
                {{$project->slug}}
            </li>

            {{-- Nome azienda --}}
            <li class="list-group-item">
                <strong>Nome Azienda</strong>:
                {{$project->client_name}}
            </li>

            {{-- descrizione --}}
            @if ($project->summary)
                <li class="list-group-item">
                    <strong>Descrizione</strong>:
                    {{$project->summary}}
                </li>
            @endif
            
        </ul>
    </div>

    {{-- data di creazione --}}
    <div class="mt-4">
        <ul class="list-group list-group-flush">
            <li class="list-group-item">
                <strong>Data creazione</strong>:
                {{$project->created_at}}
            </li>
            <li class="list-group-item">
                <strong>Data di modifica</strong>:
                {{$project->updated_at}}
            </li>
        </ul>
    </div>


    <div class="d-flex align-items-center mb-5">
        {{-- bottone modifica --}}
        <a class="mx-3 btn btn-warning" href="{{ route('admin.projects.edit', ['project' => $project->slug])}}"><i class="fa-solid fa-pen-to-square text-light"></i></a>
        {{-- bottone elimina --}}
        <form action="{{ route('admin.projects.destroy', ['project' => $project->slug])}}" method="POST">
            @csrf
            @method('DELETE')
            
            <button type="submit" class="btn btn-danger"><i class="fa-solid fa-trash-can"></i></button>
        </form>
    </div>
@endsection