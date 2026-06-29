<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Event;

/**
 * Atiende el listado y detalle público de eventos.
 *
 * Mantiene la regla de mostrar únicamente eventos publicados para el público.
 */
class EventController extends Controller
{
    /**
     * Lista eventos publicados con paginación.
     */
    public function index()
    {
        return view('public.events.index', [
            'events' => Event::query()->published()->latest('event_date')->paginate(12),
        ]);
    }

    /**
     * Muestra un evento publicado o responde 404 si no debe verse.
     */
    public function show(Event $event)
    {
        abort_unless($event->status->value === 'published', 404);
        return view('public.events.show', compact('event'));
    }
}
