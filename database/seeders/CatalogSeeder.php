<?php

namespace Database\Seeders;

use App\Enums\CompanyStatus;
use App\Enums\VacancyStatus;
use App\Models\Catalog;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

/**
 * Carga catálogos base requeridos por formularios, filtros y estados.
 *
 * Este seeder sí se debe ejecutar en producción porque deja listas las opciones
 * mínimas para capturar empresas, ciudadanos, vacantes y postulaciones.
 */
class CatalogSeeder extends Seeder
{
    /**
     * Crea valores iniciales sin duplicarlos si el comando se ejecuta otra vez.
     */
    public function run(): void
    {
        $catalogs = [
            'education_level' => ['Primaria', 'Secundaria', 'Bachillerato', 'Licenciatura', 'Posgrado'],
            'academic_status' => ['Trunco', 'En curso', 'Concluido', 'Titulado'],
            'employment_type' => ['Tiempo completo', 'Medio tiempo', 'Temporal', 'Practicante'],
            'experience_level' => ['Sin experiencia', '1 año', '2 a 3 años', 'Más de 3 años'],
            'gender' => ['Femenino', 'Masculino', 'No especificado'],
            'marital_status' => ['Soltero', 'Casado', 'Unión libre', 'Otro'],
            'municipality' => ['Lerma', 'San Mateo Atenco', 'Toluca', 'Ocoyoacac'],
            'state' => ['Estado de México'],
            'language' => ['Inglés', 'Francés', 'Otro'],
            'language_level' => ['Básico', 'Intermedio', 'Avanzado'],
            'vacancy_status' => array_column(VacancyStatus::cases(), 'value'),
            'application_status' => ['submitted', 'reviewed', 'contacted', 'hired', 'rejected', 'withdrawn'],
            'company_status' => array_column(CompanyStatus::cases(), 'value'),
            'source' => ['Portal municipal', 'Redes sociales', 'Recomendación', 'Evento'],
        ];

        foreach ($catalogs as $type => $items) {
            foreach ($items as $index => $name) {
                Catalog::firstOrCreate([
                    'type' => $type,
                    'code' => Str::slug($name),
                ], [
                    'name' => $name,
                    'sort_order' => $index + 1,
                    'is_active' => true,
                ]);
            }
        }
    }
}
