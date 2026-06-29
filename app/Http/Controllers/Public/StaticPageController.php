<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;

/**
 * Muestra páginas públicas informativas heredadas del portal anterior.
 *
 * Estas pantallas conservan el flujo público sin mezclar lógica de negocio;
 * si una página crece, debe moverse a un controlador propio.
 */
class StaticPageController extends Controller
{
    /**
     * Presenta la página informativa para ciudadanos que buscan empleo.
     */
    public function jobSeeker()
    {
        return view('public.job-seeker');
    }

    /**
     * Presenta la página informativa para empresas que desean publicar vacantes.
     */
    public function employer()
    {
        return view('public.employer');
    }
}
