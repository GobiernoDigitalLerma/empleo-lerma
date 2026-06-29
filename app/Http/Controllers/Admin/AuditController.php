<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\User;
use Illuminate\Http\Request;

/**
 * Consulta la bitácora de acciones sensibles del sistema.
 *
 * La vista permite rastrear quién hizo qué, sobre qué entidad y cuándo, sin
 * exponer valores sensibles completos en el listado principal.
 */
class AuditController extends Controller
{
    /**
     * Lista auditoría con filtros por usuario, acción, entidad y fechas.
     */
    public function index(Request $request)
    {
        $audits = AuditLog::query()
            ->with('user')
            ->when($request->filled('user_id'), fn ($query) => $query->where('user_id', $request->integer('user_id')))
            ->when($request->filled('action'), fn ($query) => $query->where('action', 'like', '%'.$request->string('action').'%'))
            ->when($request->filled('auditable_type'), fn ($query) => $query->where('auditable_type', $request->string('auditable_type')))
            ->when($request->filled('from'), fn ($query) => $query->whereDate('created_at', '>=', $request->date('from')))
            ->when($request->filled('to'), fn ($query) => $query->whereDate('created_at', '<=', $request->date('to')))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.audit.index', [
            'audits' => $audits,
            'users' => User::query()->orderBy('name')->limit(100)->get(['id', 'name', 'email']),
            'auditableTypes' => AuditLog::query()->whereNotNull('auditable_type')->distinct()->orderBy('auditable_type')->pluck('auditable_type'),
        ]);
    }
}
