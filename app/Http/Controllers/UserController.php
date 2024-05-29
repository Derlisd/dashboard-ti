<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
class UserController extends Controller
{

    public function index()
    {
        $users = User::all();
        return view('user.index', compact('users'));
    }

    public function create()
    {
        return view('user.create');
    }

    public function store(Request $request)
    {
       try {
        Log::info('recibido  : '. json_encode($request->all()));
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->perfil = $request->input('perfil');
        $user->password = bcrypt($request->input('password'));
        $user->save();
        return redirect()->route('users.index')->with('success', 'Usuario creado exitosamente.');
       } catch (\Throwable $th) {
        Log::error('Error '. $th->getMessage());
        return redirect()->route('users.index')->with('errors', 'Usuario creado exitosamente.');
       }
    }

    public function edit($id)
    {

        $user = User::find($id);
        if (!$user) {
            return redirect()->route('users.index')->with('error', 'Usuario no encontrado.');
        }
        return view('user.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        if(Auth::user()->perfil === 'Super_administrador'){
            Log::info('recibido  : '. json_encode($request->all()));
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $id,
                'password' => 'nullable|string|min:6',
            ]);
    
            $user = User::find($id);
            if (!$user) {
                return redirect()->route('users.index')->with('error', 'Usuario no encontrado.');
            }
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->perfil = $request->input('perfil');
    
            if (!empty($request->input('password'))) {
                $user->password = bcrypt($request->input('password'));
            }
            $user->save();
            return redirect()->route('users.index')->with('success', 'Usuario actualizado exitosamente.');

        }else{
            return redirect()->route('users.index')->with('success', 'No tienes permisos de administrador');
        }
        
    }

    public function destroy($id)
    {
        Log::info('recibido  : '.$id);
        if(Auth::user()->perfil === 'Super_administrador'){
            $user = User::find($id);
            $user->delete();
            return redirect()->route('users.index')->with('success', 'Usuario eliminado exitosamente.');

        }else{
            return redirect()->route('users.index')->with('success', 'No tienes permisos de administrador');
        }
        
    }
}
