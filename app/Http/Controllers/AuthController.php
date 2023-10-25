<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Cliente;
use App\Models\User;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        	    // Comprobamos si el usuario ya está logado
	    if (Auth::check()) {
	
	        // Si está logado le mostramos la vista de logados
	        return view('producto_proveedor.index');
	    }
	
	    // Si no está logado le mostramos la vista con el formulario de login
	    return view('auth.login');
	    
    }

    public function login(Request $request)
    {
        // Comprobamos que el email y la contraseña han sido introducidos
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
    
        $email = $request->input('email');
        $password = $request->input('password');
    
        // Buscamos al usuario por su email
        $user = User::where('email', $email)->first();
    
        // Verificamos si el usuario existe y si la contraseña proporcionada es correcta
        if ($user && Hash::check($password, $user->password)) {
            // Las credenciales son válidas, procedemos a establecer la sesión
            $request->session()->put('id', $user->id);
            $request->session()->put('rol', $user->rol);
            $request->session()->put('nombre', $user->name);
            $request->session()->put('email', $user->email);
            $request->session()->put('password', $user->password);
    
            if ($user->rol == 1) {
                return redirect()->route('venta.create');
            } else if ($user->rol == 2) {
                return redirect()->route('producto_proveedor.index');
            } else if ($user->rol == 3) {
                return redirect()->route('empleado.index');
            } else {
                return redirect('/');
            }
        } else {
            // Las credenciales no son válidas
            return redirect("/")->withSuccess('Los datos introducidos no son correctos');
        }
    }

    public function logout()
    {
        Auth::logout();

        session()->forget('id');
        session()->forget('rol');
        session()->forget('nombre');
        session()->forget('email');
        session()->forget('password');


        return redirect('/');
    }

    public function logados()
    {
        if (Auth::check()) {
            return view('producto_proveedor.index');
        } 

        return redirect()->route("/")->withSuccess('No tienes permisos para acceder a esta página');

    }
}
