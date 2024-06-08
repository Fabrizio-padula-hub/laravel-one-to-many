@extends('layouts.admin')

@section('content')

    <h4><strong>Modifica</strong>: {{$project->name}} </h4>

    <form action="{{ route('admin.projects.update', ['project' => $project->slug]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        {{-- Nome --}}
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $project->name }}">
        </div>
        @error('name')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror

        {{-- immagine --}}
        <label for="cover_image" class="form-label">Image</label>
        <div class="card mb-3">
            <div class="card-header">
                <input class="form-control" type="file" id="cover_image" name="cover_image">
            </div>
            <div class="card-body">
                {{-- se l'immagine è presente la stampa --}}
                @if($project->cover_image)
                    <div class="card-body">
                        <img src="{{ asset('storage/' . $project->cover_image )}}" alt="{{$project->name}}">
                    </div>
                @else
                    <small>Nessuna immagine</small>
                @endif
            </div>
        </div>
        @error('cover_image')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror

        {{-- Selezione tipo --}}
        <div class="mb-3">
            <label for="type_id" class="form-label">Type</label>
            <select class="form-select" id="type_id" name="type_id">
                <option value="">Select Type</option>
                @foreach ($types as $type)
                    <option @selected($type->id == old('type_id', $project->type_id)) value="{{ $type->id }}">{{ $type->name }}</option>
                @endforeach
            </select>
        </div>
        @error('type_id')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        
        {{-- Nome cliente --}}
        <div class="mb-3">
            <label for="client_name" class="form-label">Client Name</label>
            <input type="text" class="form-control" id="client_name" name="client_name" value="{{ $project->client_name }}">
        </div>
        @error('client_name')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror

        {{-- Descrizione --}}
        <div class="mb-3">
            <label for="summary" class="form-label">Summary</label>
            <textarea class="form-control" id="summary" name="summary" rows="10">{{ $project->summary }}</textarea>
        </div>
        @error('summary')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <button type="submit" class="btn btn-primary mb-5">Modifica</button>
    </form>
    
@endsection