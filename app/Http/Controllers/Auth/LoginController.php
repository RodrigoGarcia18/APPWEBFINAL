<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Maneja la solicitud de inicio de sesión
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Intenta autenticar al usuario
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            session(['user' => $request->email]);
            return redirect()->intended('/dashboard');
        }

        // Si la autenticación falla, redirige de vuelta al formulario de inicio de sesión
        return back()->withErrors([
            'email' => 'Las credenciales proporcionadas son incorrectas.',
        ]);
    }

    // Maneja el cierre de sesión
    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/login');
    }
}
