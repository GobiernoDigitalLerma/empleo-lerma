<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
 * Esquema limpio de Empleo Lerma 2.0.
 *
 * No depende de tablas legacy ni contiene legacy_id; todas las entidades se
 * capturan desde la nueva aplicación y se relacionan con llaves foráneas claras.
 */
return new class extends Migration
{
    /**
     * Crea las tablas de dominio en orden de dependencia.
     */
    public function up(): void
    {
        // Empresas registradas por usuarios con rol company.
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            $table->string('business_name');
            $table->string('rfc', 13)->nullable()->unique();
            $table->string('economic_activity')->nullable();
            $table->unsignedInteger('employee_count')->nullable();
            $table->string('website')->nullable();
            $table->string('primary_email')->nullable();
            $table->string('primary_phone')->nullable();
            $table->string('secondary_phone')->nullable();
            $table->string('street')->nullable();
            $table->string('external_number')->nullable();
            $table->string('internal_number')->nullable();
            $table->string('neighborhood')->nullable();
            $table->string('postal_code', 10)->nullable();
            $table->string('municipality')->nullable();
            $table->string('state')->nullable();
            $table->string('logo_path')->nullable();
            $table->string('status')->default('pending')->index();
            $table->timestamp('approved_at')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->text('rejection_reason')->nullable();
            $table->string('how_did_you_hear')->nullable();
            $table->timestamps();
        });

        // Perfil principal del ciudadano; User conserva sólo autenticación.
        Schema::create('citizen_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            $table->string('full_name');
            $table->date('birth_date')->nullable();
            $table->string('gender')->nullable();
            $table->string('marital_status')->nullable();
            $table->string('birth_state')->nullable();
            $table->string('curp', 18)->nullable()->unique();
            $table->string('phone')->nullable();
            $table->string('street')->nullable();
            $table->string('external_number')->nullable();
            $table->string('internal_number')->nullable();
            $table->string('neighborhood')->nullable();
            $table->string('postal_code', 10)->nullable();
            $table->string('municipality')->nullable();
            $table->string('state')->nullable();
            $table->boolean('has_disability')->default(false);
            $table->text('disability_description')->nullable();
            $table->string('profile_photo_path')->nullable();
            $table->string('how_did_you_hear')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });

        // Escolaridad y habilidades para CV ciudadano.
        Schema::create('citizen_education', function (Blueprint $table) {
            $table->id();
            $table->foreignId('citizen_profile_id')->constrained()->cascadeOnDelete();
            $table->string('education_level')->nullable();
            $table->string('career_or_specialty')->nullable();
            $table->string('academic_status')->nullable();
            $table->string('language')->nullable();
            $table->string('language_level')->nullable();
            $table->text('computer_skills')->nullable();
            $table->text('special_knowledge')->nullable();
            $table->text('special_skills')->nullable();
            $table->text('courses')->nullable();
            $table->timestamps();
        });

        // Experiencia laboral declarada por el ciudadano.
        Schema::create('citizen_experience', function (Blueprint $table) {
            $table->id();
            $table->foreignId('citizen_profile_id')->constrained()->cascadeOnDelete();
            $table->boolean('currently_working')->default(false);
            $table->string('company_name')->nullable();
            $table->string('job_title')->nullable();
            $table->text('functions')->nullable();
            $table->decimal('monthly_salary', 10, 2)->nullable();
            $table->string('employment_type')->nullable();
            $table->date('started_at')->nullable();
            $table->date('ended_at')->nullable();
            $table->date('job_search_started_at')->nullable();
            $table->text('separation_reason')->nullable();
            $table->string('availability')->nullable();
            $table->timestamps();
        });

        // Preferencias usadas para filtros y recomendaciones de vacantes.
        Schema::create('citizen_preferences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('citizen_profile_id')->constrained()->cascadeOnDelete();
            $table->string('desired_position')->nullable();
            $table->string('occupation')->nullable();
            $table->string('desired_employment_type')->nullable();
            $table->decimal('expected_salary', 10, 2)->nullable();
            $table->string('experience_level')->nullable();
            $table->boolean('available_to_travel')->default(false);
            $table->boolean('available_to_relocate')->default(false);
            $table->string('preferred_municipality')->nullable();
            $table->string('preferred_state')->nullable();
            $table->timestamps();
        });

        // Metadatos de documentos almacenados en storage privado.
        Schema::create('citizen_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('citizen_profile_id')->constrained()->cascadeOnDelete();
            $table->string('type')->index();
            $table->string('original_name');
            $table->string('path');
            $table->string('mime_type');
            $table->unsignedBigInteger('size');
            $table->boolean('is_current')->default(true);
            $table->timestamp('uploaded_at')->nullable();
            $table->timestamps();
        });

        // Vacantes creadas por empresas y revisadas por administración.
        Schema::create('vacancies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('short_description')->nullable();
            $table->text('functions')->nullable();
            $table->text('required_knowledge')->nullable();
            $table->text('full_address')->nullable();
            $table->string('municipality')->nullable()->index();
            $table->string('state')->nullable();
            $table->string('employment_type')->nullable()->index();
            $table->decimal('monthly_salary', 10, 2)->nullable();
            $table->string('work_days')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->unsignedInteger('open_positions')->default(1);
            $table->timestamp('expires_at')->nullable()->index();
            $table->string('status')->default('draft')->index();
            $table->boolean('is_covered')->default(false)->index();
            $table->boolean('covered_on_platform')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('rejected_at')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->timestamps();
        });

        // Requisitos y condiciones de cada vacante.
        Schema::create('vacancy_requirements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vacancy_id')->constrained()->cascadeOnDelete();
            $table->boolean('accepts_disability')->default(false);
            $table->text('disability_details')->nullable();
            $table->boolean('accepts_older_adults')->default(false);
            $table->string('vacancy_origin')->nullable();
            $table->string('education_level')->nullable();
            $table->string('career_or_specialty')->nullable();
            $table->string('academic_status')->nullable();
            $table->string('minimum_experience')->nullable();
            $table->unsignedTinyInteger('minimum_age')->nullable();
            $table->unsignedTinyInteger('maximum_age')->nullable();
            $table->string('language')->nullable();
            $table->text('computer_skills')->nullable();
            $table->string('gender_preference')->nullable();
            $table->boolean('available_to_travel')->default(false);
            $table->boolean('available_to_relocate')->default(false);
            $table->text('benefits')->nullable();
            $table->text('observations')->nullable();
            $table->timestamps();
        });

        // Datos de contacto de vacante; no deben mostrarse completos al público.
        Schema::create('vacancy_contacts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vacancy_id')->constrained()->cascadeOnDelete();
            $table->string('contact_name')->nullable();
            $table->string('position')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('preferred_contact_method')->nullable();
            $table->string('interview_days')->nullable();
            $table->time('interview_start_time')->nullable();
            $table->time('interview_end_time')->nullable();
            $table->timestamps();
        });

        // Postulaciones únicas por ciudadano y vacante.
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vacancy_id')->constrained()->cascadeOnDelete();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->foreignId('citizen_profile_id')->constrained()->cascadeOnDelete();
            $table->string('status')->default('submitted')->index();
            $table->text('cover_message')->nullable();
            $table->boolean('was_contacted')->default(false);
            $table->timestamp('contacted_at')->nullable();
            $table->timestamp('submitted_at')->nullable();
            $table->timestamps();
            $table->unique(['vacancy_id', 'citizen_profile_id']);
        });

        // Historial inmutable de cambios de estado de postulación.
        Schema::create('application_status_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained()->cascadeOnDelete();
            $table->string('from_status')->nullable();
            $table->string('to_status');
            $table->foreignId('changed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->text('notes')->nullable();
            $table->timestamp('created_at')->useCurrent();
        });

        // Eventos públicos administrados desde el panel institucional.
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->timestamp('event_date')->nullable()->index();
            $table->string('location')->nullable();
            $table->string('link')->nullable();
            $table->string('image_path')->nullable();
            $table->string('status')->default('draft')->index();
            $table->timestamp('published_at')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        // Catálogos reutilizables para formularios y filtros.
        Schema::create('catalogs', function (Blueprint $table) {
            $table->id();
            $table->string('type')->index();
            $table->foreignId('parent_id')->nullable()->constrained('catalogs')->nullOnDelete();
            $table->string('name');
            $table->string('code')->nullable()->index();
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        // Auditoría de acciones sensibles del sistema.
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('action')->index();
            $table->nullableMorphs('auditable');
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->json('old_values')->nullable();
            $table->json('new_values')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamp('created_at')->useCurrent();
        });

        // Tabla estándar de notificaciones de Laravel para mail/database.
        Schema::create('notifications', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('type');
            $table->morphs('notifiable');
            $table->text('data');
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Elimina tablas en orden inverso para respetar llaves foráneas.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
        Schema::dropIfExists('audit_logs');
        Schema::dropIfExists('catalogs');
        Schema::dropIfExists('events');
        Schema::dropIfExists('application_status_history');
        Schema::dropIfExists('applications');
        Schema::dropIfExists('vacancy_contacts');
        Schema::dropIfExists('vacancy_requirements');
        Schema::dropIfExists('vacancies');
        Schema::dropIfExists('citizen_documents');
        Schema::dropIfExists('citizen_preferences');
        Schema::dropIfExists('citizen_experience');
        Schema::dropIfExists('citizen_education');
        Schema::dropIfExists('citizen_profiles');
        Schema::dropIfExists('companies');
    }
};
