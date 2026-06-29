<?php

namespace App\Http\Controllers\Auth;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

/**
 * Gestiona inicio y cierre de sesión del portal.
 *
 * Además de autenticar, redirige por rol para que cada usuario llegue al
 * dashboard que corresponde a sus permisos.
 */
class AuthenticatedSessionController extends Controller
{
    /**
     * Muestra el formulario de login.
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Valida credenciales, registra último acceso y redirige por rol.
     */
    public function store(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            throw ValidationException::withMessages(['email' => 'Las credenciales no son válidas.']);
        }

        $request->session()->regenerate();
        $request->user()->forceFill(['last_login_at' => now()])->save();

        return redirect()->intended(match ($request->user()->role) {
            UserRole::Admin => route('admin.dashboard'),
            UserRole::Company => route('company.dashboard'),
            UserRole::Citizen => route('citizen.dashboard'),
        });
    }

    /**
     * Cierra sesión y regenera la sesión para reducir riesgo de fijación.
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }
}
