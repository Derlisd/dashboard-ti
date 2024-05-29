@extends('adminlte::page')

@section('title', 'Crear Usuario')

@section('content_header')
    <h1>Crear Usuario</h1>
@stop

    @section('content')

    <form action="{{ route('users.store') }}" method="POST">
        @if(session('success'))
            <div class="alert alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @csrf
        <div class="form-group">
            <label for="name">Nombre:</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="perfil">Perfil:</label>
            <select id="perfil" name="perfil" class="form-control">
                <option value="Desarrollador">Desarrollador</option>
                <option value="Admin">Admin</option>
                <option value="Super_administrador">Super Administrador</option>

            </select>
        </div>
        <div class="form-group">
            <label for="password">Contraseña:</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Guardar</button>
    </form>
@stop
@section('js')
    <script src="{{ asset('js/util.js') }}"></script>
     <script>
        $(document).ready(async function() {
            var userPerfil = "{{ Auth::user()->perfil }}";
            validatePermission(userPerfil)

        });
    </script>
@stop


