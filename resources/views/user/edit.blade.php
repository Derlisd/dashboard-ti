@extends('adminlte::page')

@section('title', 'Editar Usuario')

@section('content_header')
    <h1>Editar Usuario</h1>
@stop

@section('content')
    <form action="{{ route('users.update', $user->id) }}" method="POST">
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
        @method('PUT')
        <div class="form-group">
            <label for="name">Nombre:</label>
            <input type="text" name="name" value="{{ $user->name }}" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" name="email" value="{{ $user->email }}" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="perfil">Perfil:</label>
            <select id="perfil" name="perfil" value="{{ $user->perfil }}" class="form-control">
                <option value="Desarrollador" @if($user->perfil === 'Desarrollador') selected @endif>Desarrollador</option>
                <option value="Admin" @if($user->perfil === 'Admin') selected @endif>Admin</option>
                <option value="Super_administrador"  @if($user->perfil === 'Super_administrador') selected @endif >Super Administrador</option>
            </select>
        </div>
        <div class="form-group">
            <label for="password">Contraseña:</label>
            <input type="password" name="password" class="form-control" placeholder="Si no desea cambiar la contraseña deje vacío">
        </div>
        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="{{ route('users.index') }}" class="btn btn-danger">Cancelar</a>

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

