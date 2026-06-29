<?php

namespace App\Http\Controllers\Citizen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;

/**
 * Lista notificaciones del usuario ciudadano autenticado.
 */
class NotificationController extends Controller
{
    /**
     * Muestra mensajes persistidos por Laravel para el ciudadano.
     */
    public function index(Request $request)
    {
        $notifications = $request->user()
            ->notifications()
            ->when($request->filled('read'), function ($query) use ($request) {
                $request->boolean('read') ? $query->whereNotNull('read_at') : $query->whereNull('read_at');
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('citizen.notifications.index', compact('notifications'));
    }

    /**
     * Marca una notificación propia del ciudadano como leída.
     */
    public function markAsRead(Request $request, DatabaseNotification $notification)
    {
        $this->authorizeNotification($request, $notification);
        $notification->markAsRead();

        return back()->with('status', 'Notificación marcada como leída.');
    }

    /**
     * Marca como leídas todas las notificaciones pendientes del ciudadano.
     */
    public function markAllAsRead(Request $request)
    {
        $request->user()->unreadNotifications()->update(['read_at' => now()]);

        return back()->with('status', 'Notificaciones marcadas como leídas.');
    }

    /**
     * Evita que el ciudadano modifique notificaciones de otra cuenta.
     */
    private function authorizeNotification(Request $request, DatabaseNotification $notification): void
    {
        abort_unless($notification->notifiable_type === $request->user()->getMorphClass() && (int) $notification->notifiable_id === $request->user()->id, 404);
    }
}
