<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\RecordsAdminAudit;
use App\Http\Controllers\Controller;
use App\Models\Catalog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * Mantiene catálogos usados por formularios y filtros del sistema.
 *
 * Los catálogos permiten operar sin hardcodear opciones como municipio,
 * escolaridad, tipo de empleo o estados visibles para el equipo municipal.
 */
class CatalogController extends Controller
{
    use RecordsAdminAudit;

    /**
     * Lista valores agrupados por tipo y permite filtrar por grupo.
     */
    public function index(Request $request)
    {
        $catalogs = Catalog::query()
            ->with('parent')
            ->when($request->filled('type'), fn ($query) => $query->where('type', $request->string('type')))
            ->orderBy('type')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate(20)
            ->withQueryString();

        return view('admin.catalogs.index', [
            'catalogs' => $catalogs,
            'types' => Catalog::query()->distinct()->orderBy('type')->pluck('type'),
        ]);
    }

    /**
     * Guarda un nuevo valor de catálogo.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'type' => ['required', 'string', 'max:100'],
            'name' => ['required', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $catalog = Catalog::create([
            'type' => Str::snake($data['type']),
            'name' => $data['name'],
            'code' => Str::slug($data['name']),
            'sort_order' => $data['sort_order'] ?? 0,
            'is_active' => true,
        ]);

        $this->audit('admin.catalogs.create', $catalog, [], $catalog->only(['type', 'name', 'code']));

        return back()->with('status', 'Catálogo creado.');
    }

    /**
     * Activa o desactiva un valor de catálogo sin eliminarlo.
     */
    public function toggle(Catalog $catalog)
    {
        $oldValues = $catalog->only(['is_active']);

        $catalog->forceFill(['is_active' => ! $catalog->is_active])->save();

        $this->audit('admin.catalogs.toggle', $catalog, $oldValues, $catalog->only(['is_active']));

        return back()->with('status', 'Estado de catálogo actualizado.');
    }

    /**
     * Elimina un valor de catálogo sólo si todavía no fue usado.
     */
    public function destroy(Catalog $catalog)
    {
        $usageCount = $this->usageCount($catalog);

        if ($usageCount > 0) {
            return back()->withErrors([
                'catalog' => "No se puede eliminar {$catalog->name} porque ya fue usado en {$usageCount} registro(s). Puedes desactivarlo.",
            ]);
        }

        if ($catalog->children()->exists()) {
            return back()->withErrors([
                'catalog' => "No se puede eliminar {$catalog->name} porque tiene valores hijos asociados.",
            ]);
        }

        $oldValues = $catalog->only(['type', 'name', 'code', 'is_active', 'sort_order']);

        $catalog->delete();

        $this->audit('admin.catalogs.delete', $catalog, $oldValues, []);

        return back()->with('status', 'Catálogo eliminado.');
    }

    /**
     * Cuenta referencias del valor según el tipo de catálogo.
     *
     * Hoy los formularios guardan el texto del catálogo en las tablas de dominio;
     * por eso se revisan las columnas conocidas antes de permitir un borrado.
     */
    private function usageCount(Catalog $catalog): int
    {
        $usageMap = [
            'education_level' => [
                ['citizen_education', 'education_level'],
                ['vacancy_requirements', 'education_level'],
            ],
            'academic_status' => [
                ['citizen_education', 'academic_status'],
                ['vacancy_requirements', 'academic_status'],
            ],
            'employment_type' => [
                ['citizen_experience', 'employment_type'],
                ['citizen_preferences', 'desired_employment_type'],
                ['vacancies', 'employment_type'],
            ],
            'experience_level' => [
                ['citizen_preferences', 'experience_level'],
                ['vacancy_requirements', 'minimum_experience'],
            ],
            'gender' => [
                ['citizen_profiles', 'gender'],
                ['vacancy_requirements', 'gender_preference'],
            ],
            'marital_status' => [
                ['citizen_profiles', 'marital_status'],
            ],
            'municipality' => [
                ['companies', 'municipality'],
                ['citizen_profiles', 'municipality'],
                ['citizen_preferences', 'preferred_municipality'],
                ['vacancies', 'municipality'],
            ],
            'state' => [
                ['companies', 'state'],
                ['citizen_profiles', 'state'],
                ['citizen_profiles', 'birth_state'],
                ['citizen_preferences', 'preferred_state'],
                ['vacancies', 'state'],
            ],
            'language' => [
                ['citizen_education', 'language'],
                ['vacancy_requirements', 'language'],
            ],
            'language_level' => [
                ['citizen_education', 'language_level'],
            ],
            'vacancy_status' => [
                ['vacancies', 'status'],
            ],
            'application_status' => [
                ['applications', 'status'],
                ['application_status_history', 'from_status'],
                ['application_status_history', 'to_status'],
            ],
            'company_status' => [
                ['companies', 'status'],
            ],
            'event_status' => [
                ['events', 'status'],
            ],
            'source' => [
                ['companies', 'how_did_you_hear'],
                ['citizen_profiles', 'how_did_you_hear'],
                ['vacancy_requirements', 'vacancy_origin'],
            ],
        ];

        $columns = $usageMap[$catalog->type] ?? [];
        $values = collect([$catalog->name, $catalog->code])->filter()->unique()->values();

        return collect($columns)->sum(function (array $reference) use ($values) {
            [$table, $column] = $reference;

            return DB::table($table)->whereIn($column, $values)->count();
        });
    }
}
