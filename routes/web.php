<?php

use App\Http\Controllers\Admin\AuditController;
use App\Http\Controllers\Admin\CatalogController;
use App\Http\Controllers\Admin\CompanyController as AdminCompanyController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\VacancyController as AdminVacancyController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Citizen\ApplicationController as CitizenApplicationController;
use App\Http\Controllers\Citizen\DashboardController as CitizenDashboardController;
use App\Http\Controllers\Citizen\NotificationController as CitizenNotificationController;
use App\Http\Controllers\Citizen\ProfileController as CitizenProfileController;
use App\Http\Controllers\Citizen\ResumeController as CitizenResumeController;
use App\Http\Controllers\Citizen\RecommendedVacancyController as CitizenRecommendedVacancyController;
use App\Http\Controllers\Company\ApplicantController as CompanyApplicantController;
use App\Http\Controllers\Company\DashboardController as CompanyDashboardController;
use App\Http\Controllers\Company\NotificationController as CompanyNotificationController;
use App\Http\Controllers\Company\ProfileController as CompanyProfileController;
use App\Http\Controllers\Company\VacancyController as CompanyVacancyController;
use App\Http\Controllers\Public\CompanyController;
use App\Http\Controllers\Public\EventController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\StaticPageController;
use App\Http\Controllers\Public\VacancyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Rutas públicas
|--------------------------------------------------------------------------
|
| Conservan el flujo visible del portal: home, búsqueda de vacantes, eventos
| y páginas informativas heredadas del sitio legacy.
|
*/
Route::get('/', HomeController::class)->name('home');
Route::get('/busco_empleo', [StaticPageController::class, 'jobSeeker'])->name('public.job-seeker');
Route::get('/ofrezco_empleo', [StaticPageController::class, 'employer'])->name('public.employer');
Route::get('/empresas', [CompanyController::class, 'index'])->name('companies.index');
Route::get('/vacantes', [VacancyController::class, 'index'])->name('vacancies.index');
Route::get('/vacantes/{vacancy:slug}', [VacancyController::class, 'show'])->name('vacancies.show');
Route::get('/search', [VacancyController::class, 'index'])->name('buscar');
Route::get('/vacante/{vacancy:slug}', [VacancyController::class, 'show'])->name('vacante');
Route::get('/eventos', [EventController::class, 'index'])->name('events.index');
Route::get('/eventos/{event:slug}', [EventController::class, 'show'])->name('events.show');

/*
|--------------------------------------------------------------------------
| Autenticación
|--------------------------------------------------------------------------
|
| Laravel maneja la sesión web; las rutas se mantienen explícitas para que
| sea claro dónde aplicar rate limiting y redirecciones por rol.
|
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])->middleware('throttle:5,1');
    Route::get('/registro/{type?}', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/registro', [RegisteredUserController::class, 'store'])->middleware('throttle:5,1');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
    Route::get('/verificar-correo', EmailVerificationPromptController::class)->name('verification.notice');
    Route::get('/verificar-correo/{id}/{hash}', VerifyEmailController::class)->middleware(['signed', 'throttle:6,1'])->name('verification.verify');
    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('status', 'verification-link-sent');
    })->middleware('throttle:6,1')->name('verification.send');
});

/*
|--------------------------------------------------------------------------
| Dashboards por rol
|--------------------------------------------------------------------------
|
| Cada grupo comparte autenticación, verificación, acceso activo y rol. Las
| secciones placeholder sostienen la navegación mientras se construyen CRUDs.
|
*/
Route::middleware(['auth', 'verified', 'access.active', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', AdminDashboardController::class)->name('dashboard');

    Route::get('/usuarios', [UserController::class, 'index'])->name('users.index');
    Route::patch('/usuarios/{user}/activar', [UserController::class, 'activate'])->name('users.activate');
    Route::patch('/usuarios/{user}/renovar', [UserController::class, 'renew'])->name('users.renew');
    Route::patch('/usuarios/{user}/suspender', [UserController::class, 'suspend'])->name('users.suspend');
    Route::patch('/usuarios/{user}/revocar', [UserController::class, 'revoke'])->name('users.revoke');

    Route::get('/empresas', [AdminCompanyController::class, 'index'])->name('companies.index');
    Route::patch('/empresas/{company}/aprobar', [AdminCompanyController::class, 'approve'])->name('companies.approve');
    Route::patch('/empresas/{company}/suspender', [AdminCompanyController::class, 'suspend'])->name('companies.suspend');
    Route::patch('/empresas/{company}/rechazar', [AdminCompanyController::class, 'reject'])->name('companies.reject');

    Route::get('/vacantes', [AdminVacancyController::class, 'index'])->name('vacancies.index');
    Route::get('/vacantes/{vacancy}', [AdminVacancyController::class, 'show'])->name('vacancies.show');
    Route::patch('/vacantes/{vacancy}/aprobar', [AdminVacancyController::class, 'approve'])->name('vacancies.approve');
    Route::patch('/vacantes/{vacancy}/rechazar', [AdminVacancyController::class, 'reject'])->name('vacancies.reject');
    Route::patch('/vacantes/{vacancy}/cubierta', [AdminVacancyController::class, 'markCovered'])->name('vacancies.covered');

    Route::get('/eventos', [AdminEventController::class, 'index'])->name('events.index');
    Route::get('/eventos/nuevo', [AdminEventController::class, 'create'])->name('events.create');
    Route::post('/eventos', [AdminEventController::class, 'store'])->name('events.store');
    Route::get('/eventos/{event}/editar', [AdminEventController::class, 'edit'])->name('events.edit');
    Route::put('/eventos/{event}', [AdminEventController::class, 'update'])->name('events.update');
    Route::patch('/eventos/{event}/publicar', [AdminEventController::class, 'publish'])->name('events.publish');
    Route::patch('/eventos/{event}/archivar', [AdminEventController::class, 'archive'])->name('events.archive');

    Route::get('/catalogos', [CatalogController::class, 'index'])->name('catalogs.index');
    Route::post('/catalogos', [CatalogController::class, 'store'])->name('catalogs.store');
    Route::patch('/catalogos/{catalog}/alternar', [CatalogController::class, 'toggle'])->name('catalogs.toggle');
    Route::delete('/catalogos/{catalog}', [CatalogController::class, 'destroy'])->name('catalogs.destroy');

    Route::get('/notificaciones', [NotificationController::class, 'index'])->name('notifications.index');
    Route::patch('/notificaciones/{notification}/leida', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::patch('/notificaciones/leidas/todas', [NotificationController::class, 'markAllAsRead'])->name('notifications.read-all');
    Route::get('/auditoria', [AuditController::class, 'index'])->name('audit.index');
});

Route::middleware(['auth', 'verified', 'access.active', 'role:company'])->prefix('empresa')->name('company.')->group(function () {
    Route::get('/dashboard', CompanyDashboardController::class)->name('dashboard');
    Route::get('/perfil', [CompanyProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/perfil', [CompanyProfileController::class, 'update'])->name('profile.update');

    Route::get('/vacantes', [CompanyVacancyController::class, 'index'])->name('vacancies.index');
    Route::get('/vacantes/nueva', [CompanyVacancyController::class, 'create'])->name('vacancies.create');
    Route::post('/vacantes', [CompanyVacancyController::class, 'store'])->name('vacancies.store');
    Route::get('/vacantes/{vacancy}/editar', [CompanyVacancyController::class, 'edit'])->name('vacancies.edit');
    Route::put('/vacantes/{vacancy}', [CompanyVacancyController::class, 'update'])->name('vacancies.update');
    Route::patch('/vacantes/{vacancy}/cubierta', [CompanyVacancyController::class, 'markCovered'])->name('vacancies.covered');

    Route::get('/postulados', [CompanyApplicantController::class, 'index'])->name('applicants.index');
    Route::patch('/postulados/{application}/estado', [CompanyApplicantController::class, 'updateStatus'])->name('applicants.status');
    Route::get('/postulados/{application}/cv', [CompanyApplicantController::class, 'downloadCv'])->name('applicants.cv');

    Route::get('/notificaciones', [CompanyNotificationController::class, 'index'])->name('notifications.index');
    Route::patch('/notificaciones/{notification}/leida', [CompanyNotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::patch('/notificaciones/leidas/todas', [CompanyNotificationController::class, 'markAllAsRead'])->name('notifications.read-all');
});

Route::middleware(['auth', 'verified', 'access.active', 'role:citizen'])->prefix('ciudadano')->name('citizen.')->group(function () {
    Route::get('/dashboard', CitizenDashboardController::class)->name('dashboard');
    Route::get('/perfil', [CitizenProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/perfil', [CitizenProfileController::class, 'update'])->name('profile.update');
    Route::get('/curriculum', [CitizenResumeController::class, 'edit'])->name('resume.edit');
    Route::put('/curriculum', [CitizenResumeController::class, 'update'])->name('resume.update');
    Route::post('/curriculum/cv', [CitizenResumeController::class, 'uploadCv'])->name('resume.cv.upload');
    Route::get('/curriculum/pdf', [CitizenResumeController::class, 'downloadPdf'])->name('resume.pdf');
    Route::get('/postulaciones', [CitizenApplicationController::class, 'index'])->name('applications.index');
    Route::get('/vacantes-para-mi', [CitizenRecommendedVacancyController::class, 'index'])->name('vacancies.recommended');
    Route::post('/vacantes/{vacancy}/postular', [CitizenRecommendedVacancyController::class, 'apply'])->name('vacancies.apply');
    Route::get('/notificaciones', [CitizenNotificationController::class, 'index'])->name('notifications.index');
    Route::patch('/notificaciones/{notification}/leida', [CitizenNotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::patch('/notificaciones/leidas/todas', [CitizenNotificationController::class, 'markAllAsRead'])->name('notifications.read-all');
});
