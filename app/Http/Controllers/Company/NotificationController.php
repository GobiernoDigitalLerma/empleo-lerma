<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;

/**
 * Lista notificaciones del usuario empresa autenticado.
 */
class NotificationController extends Controller
{
    /**
     * Muestra mensajes internos enviados a la cuenta empresa.
     */
    public function index(Request $request)
    {
        $notifications = $request->user()
            ->notifications()
            ->when($request->filled('read'), function ($query) use ($request) {
                $request->boolean('read')
                    ? $query->whereNotNull('read_at')
                    : $query->whereNull('read_at');
            })
            ->paginate(15)
            ->withQueryString();

        return view('company.notifications.index', compact('notifications'));
    }

    /**
     * Marca una notificación propia de la empresa como leída.
     */
    public function markAsRead(Request $request, DatabaseNotification $notification)
    {
        $this->authorizeNotification($request, $notification);
        $notification->markAsRead();

        return back()->with('status', 'Notificación marcada como leída.');
    }

    /**
     * Marca como leídas todas las notificaciones pendientes de la empresa.
     */
    public function markAllAsRead(Request $request)
    {
        $request->user()->unreadNotifications()->update(['read_at' => now()]);

        return back()->with('status', 'Notificaciones marcadas como leídas.');
    }

    /**
     * Impide que una empresa marque notificaciones de otro usuario.
     */
    private function authorizeNotification(Request $request, DatabaseNotification $notification): void
    {
        abort_unless($notification->notifiable_type === $request->user()->getMorphClass() && (int) $notification->notifiable_id === $request->user()->id, 404);
    }
}
