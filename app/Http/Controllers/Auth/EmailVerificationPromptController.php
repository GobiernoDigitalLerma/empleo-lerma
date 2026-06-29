<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * Decide si el usuario debe ver la pantalla de verificación de correo.
 */
class EmailVerificationPromptController extends Controller
{
    /**
     * Redirige usuarios ya verificados y muestra aviso a los pendientes.
     */
    public function __invoke(Request $request)
    {
        return $request->user()->hasVerifiedEmail()
            ? redirect()->route('home')
            : view('auth.verify-email');
    }
}
