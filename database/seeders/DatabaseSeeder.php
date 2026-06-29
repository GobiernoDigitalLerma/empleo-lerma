<?php

namespace Database\Seeders;

use App\Enums\AccessStatus;
use App\Enums\CompanyStatus;
use App\Enums\EventStatus;
use App\Enums\UserRole;
use App\Enums\VacancyStatus;
use App\Models\CitizenEducation;
use App\Models\CitizenExperience;
use App\Models\CitizenPreference;
use App\Models\CitizenProfile;
use App\Models\Company;
use App\Models\Event;
use App\Models\User;
use App\Models\Vacancy;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * Carga inicial mínima para operar Empleo Lerma 2.0 sin datos legacy.
 */
class DatabaseSeeder extends Seeder
{
    /**
     * Crea admin, catálogos base y datos demo para validar el portal.
     */
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            CatalogSeeder::class,
        ]);

        $admin = User::where('role', UserRole::Admin)->firstOrFail();

        /*
         * Ciudadano demo para validar acceso, dashboard y flujo de perfil.
         *
         * El perfil queda completo según la regla mínima del modelo:
         * nombre, CURP, teléfono y completed_at.
         */
        $citizenUser = User::updateOrCreate(
            ['email' => 'ciudadano.demo@lerma.gob.mx'],
            [
                'name' => 'Ciudadano Demo',
                'phone' => '7280000100',
                'password' => Hash::make('Password123!'),
                'role' => UserRole::Citizen,
                'status' => AccessStatus::Active,
                'access_expires_at' => now()->addYear(),
                'email_verified_at' => now(),
            ]
        );

        $citizenProfile = CitizenProfile::updateOrCreate(
            ['user_id' => $citizenUser->id],
            [
                'full_name' => 'Ciudadano Demo Lerma',
                'birth_date' => '1996-05-15',
                'gender' => 'No especificado',
                'marital_status' => 'Soltero',
                'birth_state' => 'Estado de México',
                'curp' => 'DELC960515HMCMMR01',
                'phone' => '7280000100',
                'street' => 'Av. Reolín Barejón',
                'external_number' => '100',
                'neighborhood' => 'Centro',
                'postal_code' => '52000',
                'municipality' => 'Lerma',
                'state' => 'Estado de México',
                'has_disability' => false,
                'how_did_you_hear' => 'Portal municipal',
                'completed_at' => now(),
            ]
        );

        CitizenEducation::updateOrCreate(
            ['citizen_profile_id' => $citizenProfile->id],
            [
                'education_level' => 'Bachillerato',
                'career_or_specialty' => 'Administración',
                'academic_status' => 'Concluido',
                'language' => 'Inglés',
                'language_level' => 'Básico',
                'computer_skills' => 'Paquetería Office, correo electrónico y captura de datos.',
                'special_knowledge' => 'Atención al cliente y control documental.',
                'special_skills' => 'Organización, comunicación y trabajo en equipo.',
                'courses' => 'Curso básico de empleabilidad.',
            ]
        );

        CitizenExperience::updateOrCreate(
            ['citizen_profile_id' => $citizenProfile->id],
            [
                'currently_working' => false,
                'company_name' => 'Comercio local',
                'job_title' => 'Auxiliar administrativo',
                'functions' => 'Atención a clientes, archivo, captura y seguimiento de solicitudes.',
                'monthly_salary' => 8500,
                'employment_type' => 'Tiempo completo',
                'started_at' => now()->subYears(2)->toDateString(),
                'ended_at' => now()->subMonths(3)->toDateString(),
                'job_search_started_at' => now()->subMonth()->toDateString(),
                'separation_reason' => 'Terminación de contrato.',
                'availability' => 'Inmediata',
            ]
        );

        CitizenPreference::updateOrCreate(
            ['citizen_profile_id' => $citizenProfile->id],
            [
                'desired_position' => 'Auxiliar administrativo',
                'occupation' => 'Administración',
                'desired_employment_type' => 'Tiempo completo',
                'expected_salary' => 9500,
                'experience_level' => '1 año',
                'available_to_travel' => false,
                'available_to_relocate' => false,
                'preferred_municipality' => 'Lerma',
                'preferred_state' => 'Estado de México',
            ]
        );

        /*
         * Empresas y vacantes demo visibles en el home.
         *
         * Son datos nuevos, no legacy. Cada elemento crea un usuario empresa,
         * la empresa aprobada y una vacante publicada para validar listados,
         * carruseles, filtros y detalles públicos desde una instalación limpia.
         */
        $demoCompanies = [
            [
                'user_name' => 'Manufacturas Lerma',
                'email' => 'manufacturas@lerma.gob.mx',
                'business_name' => 'Manufacturas Lerma',
                'rfc' => 'MLE260617A10',
                'activity' => 'Manufactura',
                'phone' => '7280000001',
                'vacancy' => [
                    'title' => 'Auxiliar administrativo',
                    'description' => 'Apoyo en captura, control documental y seguimiento administrativo.',
                    'functions' => 'Atención a proveedores, captura de información y archivo físico/digital.',
                    'employment_type' => 'Tiempo completo',
                    'salary' => 9000,
                    'positions' => 2,
                ],
            ],
            [
                'user_name' => 'Logística del Valle',
                'email' => 'logistica.valle@lerma.gob.mx',
                'business_name' => 'Logística del Valle',
                'rfc' => 'LDV260617B20',
                'activity' => 'Logística',
                'phone' => '7280000002',
                'vacancy' => [
                    'title' => 'Operador de almacén',
                    'description' => 'Recepción, acomodo y surtido de mercancía en centro logístico.',
                    'functions' => 'Inventarios, carga ligera, etiquetado y control de entradas y salidas.',
                    'employment_type' => 'Tiempo completo',
                    'salary' => 9800,
                    'positions' => 4,
                ],
            ],
            [
                'user_name' => 'Servicios Industriales Lerma',
                'email' => 'servicios.industriales@lerma.gob.mx',
                'business_name' => 'Servicios Industriales Lerma',
                'rfc' => 'SIL260617C30',
                'activity' => 'Servicios industriales',
                'phone' => '7280000003',
                'vacancy' => [
                    'title' => 'Técnico de mantenimiento',
                    'description' => 'Mantenimiento preventivo y correctivo a equipo industrial.',
                    'functions' => 'Revisión de maquinaria, bitácoras, ajustes básicos y reportes de servicio.',
                    'employment_type' => 'Tiempo completo',
                    'salary' => 12500,
                    'positions' => 2,
                ],
            ],
            [
                'user_name' => 'Comercializadora Centro Lerma',
                'email' => 'comercializadora@lerma.gob.mx',
                'business_name' => 'Comercializadora Centro Lerma',
                'rfc' => 'CCL260617D40',
                'activity' => 'Comercio',
                'phone' => '7280000004',
                'vacancy' => [
                    'title' => 'Asesor de ventas',
                    'description' => 'Atención a clientes, seguimiento de prospectos y cierre de ventas.',
                    'functions' => 'Cotizaciones, llamadas de seguimiento, registro de clientes y apoyo en piso.',
                    'employment_type' => 'Medio tiempo',
                    'salary' => 7600,
                    'positions' => 3,
                ],
            ],
            [
                'user_name' => 'Tecnología Lerma Norte',
                'email' => 'tecnologia.norte@lerma.gob.mx',
                'business_name' => 'Tecnología Lerma Norte',
                'rfc' => 'TLN260617E50',
                'activity' => 'Tecnología',
                'phone' => '7280000005',
                'vacancy' => [
                    'title' => 'Soporte técnico junior',
                    'description' => 'Atención de incidencias básicas de hardware, software y redes.',
                    'functions' => 'Mesa de ayuda, instalación de equipo, seguimiento de tickets y documentación.',
                    'employment_type' => 'Tiempo completo',
                    'salary' => 11000,
                    'positions' => 1,
                ],
            ],
        ];

        // Limpia la empresa demo usada en una versión previa del seeder.
        User::where('email', 'empresa.demo@lerma.gob.mx')->delete();

        foreach ($demoCompanies as $index => $demoCompany) {
            $companyUser = User::updateOrCreate(
                ['email' => $demoCompany['email']],
                [
                    'name' => $demoCompany['user_name'],
                    'password' => Hash::make('Password123!'),
                    'role' => UserRole::Company,
                    'status' => AccessStatus::Active,
                    'access_expires_at' => now()->addYear(),
                    'email_verified_at' => now(),
                ]
            );

            $company = Company::updateOrCreate(
                ['user_id' => $companyUser->id],
                [
                    'business_name' => $demoCompany['business_name'],
                    'rfc' => $demoCompany['rfc'],
                    'economic_activity' => $demoCompany['activity'],
                    'primary_email' => $demoCompany['email'],
                    'primary_phone' => $demoCompany['phone'],
                    'municipality' => 'Lerma',
                    'state' => 'Estado de México',
                    'logo_path' => 'images/brand/empresa-demo.svg',
                    'status' => CompanyStatus::Active,
                    'approved_at' => now(),
                    'approved_by' => $admin->id,
                ]
            );

            Vacancy::updateOrCreate(
                ['slug' => Str::slug($demoCompany['vacancy']['title']).'-demo'],
                [
                    'company_id' => $company->id,
                    'title' => $demoCompany['vacancy']['title'],
                    'short_description' => $demoCompany['vacancy']['description'],
                    'functions' => $demoCompany['vacancy']['functions'],
                    'municipality' => 'Lerma',
                    'state' => 'Estado de México',
                    'employment_type' => $demoCompany['vacancy']['employment_type'],
                    'monthly_salary' => $demoCompany['vacancy']['salary'],
                    'open_positions' => $demoCompany['vacancy']['positions'],
                    'expires_at' => now()->addMonth()->addDays($index * 3),
                    'status' => VacancyStatus::Published,
                    'published_at' => now()->subDays($index),
                    'approved_at' => now()->subDays($index),
                    'approved_by' => $admin->id,
                ]
            );
        }

        // Evento demo publicado para validar la sección pública de eventos.
        Event::updateOrCreate(
            ['slug' => 'jornada-empleo-lerma-demo'],
            [
                'title' => 'Jornada de empleo Lerma',
                'description' => 'Evento demo para empresas y ciudadanía.',
                'event_date' => now()->addWeeks(2),
                'location' => 'Lerma, Estado de México',
                'image_path' => 'images/brand/evento-empleo-demo.svg',
                'status' => EventStatus::Published,
                'published_at' => now(),
                'created_by' => $admin->id,
                'updated_by' => $admin->id,
            ]
        );
    }
}
