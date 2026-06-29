<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;

/**
 * Consulta notificaciones propias del administrador autenticado.
 */
class NotificationController extends Controller
{
    /**
     * Lista notificaciones del admin actual con filtro de lectura.
     */
    public function index(Request $request)
    {
        $notifications = DatabaseNotification::query()
            ->where('notifiable_type', User::class)
            ->where('notifiable_id', $request->user()->id)
            ->when($request->filled('read'), function ($query) use ($request) {
                $request->boolean('read')
                    ? $query->whereNotNull('read_at')
                    : $query->whereNull('read_at');
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.notifications.index', [
            'notifications' => $notifications,
            'users' => User::query()->where('role', UserRole::Admin->value)->orderBy('name')->limit(100)->get(['id', 'name', 'email']),
        ]);
    }

    /**
     * Marca una notificación como leída desde la bandeja administrativa.
     */
    public function markAsRead(DatabaseNotification $notification)
    {
        abort_unless($notification->notifiable_type === User::class && (int) $notification->notifiable_id === auth()->id(), 404);

        $notification->markAsRead();

        return back()->with('status', 'Notificación marcada como leída.');
    }

    /**
     * Marca como leídas las notificaciones filtradas o todas si no hay filtro.
     */
    public function markAllAsRead(Request $request)
    {
        DatabaseNotification::query()
            ->where('notifiable_type', User::class)
            ->where('notifiable_id', $request->user()->id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return back()->with('status', 'Notificaciones marcadas como leídas.');
    }
}
