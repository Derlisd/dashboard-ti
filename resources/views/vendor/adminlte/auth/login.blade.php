@extends('adminlte::auth.auth-page', ['auth_type' => 'login'])

@section('adminlte_css_pre')
    <link rel="stylesheet" href="{{ asset('vendor/icheck-bootstrap/icheck-bootstrap.min.css') }}">
@stop

@php( $login_url = View::getSection('login_url') ?? config('adminlte.login_url', 'login') )
@php( $register_url = View::getSection('register_url') ?? config('adminlte.register_url', 'register') )
@php( $password_reset_url = View::getSection('password_reset_url') ?? config('adminlte.password_reset_url', 'password/reset') )

@if (config('adminlte.use_route_url', false))
    @php( $login_url = $login_url ? route($login_url) : '' )
    @php( $register_url = $register_url ? route($register_url) : '' )
    @php( $password_reset_url = $password_reset_url ? route($password_reset_url) : '' )
@else
    @php( $login_url = $login_url ? url($login_url) : '' )
    @php( $register_url = $register_url ? url($register_url) : '' )
    @php( $password_reset_url = $password_reset_url ? url($password_reset_url) : '' )
@endif

@section('auth_header', __('adminlte::adminlte.login_message'))

@section('auth_body')
    <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="loginModalLabel" style="color:black">Verifique su correo</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="token" style="color:black">Ingrese el código recibido:</label>
                        <input type="text" maxlength="4" class="form-control" id="token">
                    </div>
                    <button type="button" class="btn btn-primary" id="validateButton">Validar</button>
                </div>
            </div>
        </div>
    </div>
    <form action="{{ $login_url }}" id="loginForm" method="post">
        @csrf
        {{-- Email field --}}
        <div class="input-group mb-3">
            <input type="email" name="email" id="email"  class="form-control @error('email') is-invalid @enderror"
                   value="{{ old('email') }}" placeholder="{{ __('adminlte::adminlte.email') }}" autofocus>

            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-envelope {{ config('adminlte.classes_auth_icon', '') }}"></span>
                </div>
            </div>

            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        {{-- Password field --}}
        <div class="input-group mb-3">
            <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror"
                   placeholder="{{ __('adminlte::adminlte.password') }}">

            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-lock {{ config('adminlte.classes_auth_icon', '') }}"></span>
                </div>
            </div>

            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        {{-- Login field --}}
        <div class="row">
            <div class="col-7">
                <div class="icheck-primary" title="{{ __('adminlte::adminlte.remember_me_hint') }}">
                    <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                    <label for="remember">
                        {{ __('adminlte::adminlte.remember_me') }}
                    </label>
                </div>
            </div>

            <div class="col-5">
                <button class="btn btn-block {{ config('adminlte.classes_auth_btn', 'btn-flat btn-primary') }}" id="ingresarButton">
                    <span class="fas fa-sign-in-alt"></span>
                    {{ __('adminlte::adminlte.sign_in') }}
                </button>
            </div>
        </div>

    </form>
   
@stop

@section('auth_footer')
    {{-- Password reset link --}}
    @if($password_reset_url)
        <p class="my-0">
            <a href="{{ $password_reset_url }}">
                {{ __('adminlte::adminlte.i_forgot_my_password') }}
            </a>
        </p>
    @endif

    {{-- Register link --}}
    @if($register_url)
        <p class="my-0">
            <a href="{{ $register_url }}">
                {{ __('adminlte::adminlte.register_a_new_membership') }}
            </a>
        </p>
    @endif
@stop
@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/AlertifyJS/1.13.1/css/alertify.css" integrity="sha512-MpdEaY2YQ3EokN6lCD6bnWMl5Gwk7RjBbpKLovlrH6X+DRokrPRAF3zQJl1hZUiLXfo2e9MrOt+udOnHCAmi5w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/AlertifyJS/1.13.1/css/alertify.min.css" integrity="sha512-IXuoq1aFd2wXs4NqGskwX2Vb+I8UJ+tGJEu/Dc0zwLNKeQ7CW3Sr6v0yU3z5OQWe3eScVIkER4J9L7byrgR/fA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .spin {
        animation: spin 1s infinite linear;
        }

        @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    </style>
@stop

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/AlertifyJS/1.13.1/alertify.min.js" integrity="sha512-JnjG+Wt53GspUQXQhc+c4j8SBERsgJAoHeehagKHlxQN+MtCCmFDghX9/AcbkkNRZptyZU4zC8utK59M5L45Iw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/AlertifyJS/1.13.1/alertify.js" integrity="sha512-eOUPKZXJTfgptSYQqVilRmxUNYm0XVHwcRHD4mdtCLWf/fC9XWe98IT8H1xzBkLL4Mo9GL0xWMSJtgS5te9rQA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    
<script>
    var VALIDAR_LONGITUD = true;
    $(document).ready(function() {
        alertify.set('notifier', 'position', 'top-right');

        $('#ingresarButton').click(async function (e) {
            $('#ingresarButton').html('<i class="fas fa-spinner fa-lg spin"></i>');

            e.preventDefault();
            let response  = await generateToken()
            if(response.status){
                $('#loginModalLabel').val('Verifique su correo')
                 $('#loginModal').modal('show');          

            }else{
                alertify.error(response.message);
            }
            $('#ingresarButton').html('<span class="fas fa-sign-in-alt"></span> Ingresar');

        
        });

        $('#validateButton').click(() => {
            validateToken();
        });

        // $("#token").keyup((e) => {
        //     let value = $("#token").val();
        //     console.log(value,value.length)
        //     if (value.length === 4 && VALIDAR_LONGITUD === true) {
        //         console.log('validando..')
        //         VALIDAR_LONGITUD = false
        //         validateToken();
        //     }
        // })
        const validateToken = async () =>{
            let email  = $('#email').val();
            let password = $('#password').val();
            let token = $('#token').val();
            token = parseInt($('#token').val());

            if (token > 0) {
                let response = await checkToken(token);
                console.log(response)
                if(response.status === true){
                    VALIDAR_LONGITUD = false;
                    console.log('enviando')
                    alertify.success(response.message); 
                    $('#loginForm').submit();
                }else{
                    VALIDAR_LONGITUD = true;
                    alertify.error(response.message); 
                }

            } else {
                alertify.error('Dígito inválido');
            }
        }
        const generateToken= async () =>{
            let email  = $('#email').val();
            let password  = $('#password').val();
            let result;
            try {
                result = await $.ajax({
                headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                method: 'POST',
                data:{'email' : email,'password':password},
                url: '{{ route('generate_token') }}',
                dataType: "json",
                });
                return result;
            } catch (error) {
                console.error(error);
            }
        }
        const checkToken= async (token) =>{
            let result;
            let email  = $('#email').val();
            let password  = $('#password').val();

            try {
                result = await $.ajax({
                headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                method: 'POST',
                data:{'email' : email,'password':password,'token_v':token},
                url: '{{ route('check_token') }}',
                dataType: "json",
                });
                return result;
            } catch (error) {
                console.error(error);
            }
        }
    });

</script>
@stop
