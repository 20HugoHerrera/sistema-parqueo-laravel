@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">{{ isset($espacio) ? 'Editar Espacio' : 'Agregar Espacio' }}</h2>

    <form action="{{ isset($espacio) ? route('espacios.update', $espacio) : route('espacios.store') }}" method="POST">
        @csrf
        @if(isset($espacio)) @method('PUT') @endif

        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" name="nombre" id="nombre" class="form-control" value="{{ $espacio->nombre ?? old('nombre') }}" required>
        </div>

        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea name="descripcion" id="descripcion" class="form-control">{{ $espacio->descripcion ?? old('descripcion') }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Guardar</button>
        <a href="{{ route('espacios.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
