<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Token;
use App\Models\User;
use App\Mail\TokenMail;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function str_random(){
        return strval(mt_rand(1000, 9999));
    }
    public function generateToken(Request $request)
    {
        try {
            $token = $this->str_random();
            $email = $request->input('email');
            $password = $request->input('password');

            // Buscar al usuario por su dirección de correo electrónico
            $user = User::where('email', $email)->first();

            if (empty($user)) {
                return response()->json(['status' => false, 'message' => 'Usuario o contraseña incorrecta']);
            }

            // Validar la contraseña del usuario
            if (Hash::check($password, $user->password)) {
                // La contraseña coincide, continuar con la generación y envío del token
                $newToken = new Token([
                    'email' => $email,
                    'token' => $token,
                    'used' => false,
                ]);
                $newToken->save();

                // Envía el token al correo electrónico del usuario
                Mail::to($email)->send(new TokenMail($token));

                return response()->json(['status' => true, 'message' => 'Notificación enviada']);
            } else {
                // La contraseña no coincide
                return response()->json(['status' => false, 'message' => 'Usuario o contraseña incorrecta']);
            }
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => $th->getMessage()]);
        }

    }


    public function checkToken(Request $request)
    {
        $token = $request->input('token_v');
        $email = $request->input('email');

        // Busca el token en la base de datos
        $tokenModel = Token::where('email', $email)
            ->where('token', $token)
            ->where('used', false)
            ->first();

        if (!empty($tokenModel)) {

            // $user = User::where('email', $email)->first();
            $tokenModel->delete();

            return response()->json(['status' => true,'message' => 'Token validado']);

        } else {
            // Token inválido, muestra un mensaje de error
            return response()->json(['status' => false,'message' => 'Token inválido']);
        }
    }


}
