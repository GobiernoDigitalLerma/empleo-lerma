<?php

namespace App\Http\Controllers\Admin;

use App\Enums\AccessStatus;
use App\Http\Controllers\Admin\Concerns\RecordsAdminAudit;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

/**
 * Administra ciudadanos registrados desde el panel municipal.
 *
 * Este controlador concentra el listado y las acciones de acceso para que el
 * equipo admin pueda suspender, revocar o renovar ciudadanos sin tocar base de datos.
 * Las empresas viven en su propio módulo y los administradores no se exponen aquí.
 */
class UserController extends Controller
{
    use RecordsAdminAudit;

    /**
     * Lista sólo ciudadanos con filtros por búsqueda y estado de acceso.
     */
    public function index(Request $request)
    {
        $users = User::query()
            ->where('role', \App\Enums\UserRole::Citizen)
            ->with('citizenProfile')
            ->when($request->filled('q'), function ($query) use ($request) {
                $search = $request->string('q');

                $query->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%");
                });
            })
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->string('status')))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.users.index', [
            'users' => $users,
            'statuses' => AccessStatus::cases(),
        ]);
    }

    /**
     * Activa el acceso de un usuario y renueva su vigencia por un año.
     */
    public function activate(User $user)
    {
        $this->ensureCitizen($user);

        $oldValues = $user->only(['status', 'access_expires_at', 'revoked_at']);

        $user->forceFill([
            'status' => AccessStatus::Active,
            'access_expires_at' => now()->addYear(),
            'revoked_at' => null,
        ])->save();

        $this->audit('admin.users.activate', $user, $oldValues, $user->only(['status', 'access_expires_at', 'revoked_at']));

        return back()->with('status', 'Usuario activado y renovado.');
    }

    /**
     * Renueva la vigencia manteniendo activo al usuario.
     */
    public function renew(User $user)
    {
        $this->ensureCitizen($user);

        $oldValues = $user->only(['status', 'access_expires_at']);

        $user->forceFill([
            'status' => AccessStatus::Active,
            'access_expires_at' => now()->addYear(),
        ])->save();

        $this->audit('admin.users.renew', $user, $oldValues, $user->only(['status', 'access_expires_at']));

        return back()->with('status', 'Vigencia renovada por un año.');
    }

    /**
     * Suspende temporalmente el acceso del usuario.
     */
    public function suspend(User $user)
    {
        $this->ensureCitizen($user);

        $oldValues = $user->only(['status']);

        $user->forceFill(['status' => AccessStatus::Suspended])->save();

        $this->audit('admin.users.suspend', $user, $oldValues, $user->only(['status']));

        return back()->with('status', 'Usuario suspendido.');
    }

    /**
     * Revoca el acceso del usuario y registra la fecha de revocación.
     */
    public function revoke(User $user)
    {
        $this->ensureCitizen($user);

        $oldValues = $user->only(['status', 'revoked_at']);

        $user->forceFill([
            'status' => AccessStatus::Revoked,
            'revoked_at' => now(),
        ])->save();

        $this->audit('admin.users.revoke', $user, $oldValues, $user->only(['status', 'revoked_at']));

        return back()->with('status', 'Usuario revocado.');
    }

    /**
     * Evita que las acciones de este módulo modifiquen empresas o administradores.
     */
    private function ensureCitizen(User $user): void
    {
        abort_unless($user->isCitizen(), 404);
    }
}
