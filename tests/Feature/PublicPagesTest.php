<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Pruebas mínimas de páginas públicas que no requieren sesión.
 */
class PublicPagesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * El home debe cargar con datos iniciales y mostrar la marca.
     */
    public function test_home_page_loads(): void
    {
        $this->seed();

        $this->get('/')
            ->assertOk()
            ->assertSee('Empleo Lerma')
            ->assertSee('Ver todas')
            ->assertDontSee('companyCarousel');
    }

    /**
     * El listado público de vacantes debe responder aunque no haya filtros.
     */
    public function test_vacancies_page_loads(): void
    {
        $this->seed();

        $this->get('/vacantes')
            ->assertOk()
            ->assertSee('Vacantes')
            ->assertSee('Todos los municipios')
            ->assertSee('Todos los tipos')
            ->assertSee('Se muestran hasta 12 vacantes por página antes de paginar.')
            ->assertSee('Publicada')
            ->assertSee('images/brand/empresa-demo.svg');
    }

    /**
     * El detalle de vacante muestra sidebar de empresa y vacantes similares.
     */
    public function test_vacancy_detail_shows_company_sidebar_and_similar_vacancies(): void
    {
        $this->seed();

        $this->get('/vacantes/auxiliar-administrativo-demo')
            ->assertOk()
            ->assertSee('Manufacturas Lerma')
            ->assertSee('Registrarme para postular')
            ->assertSee('Vacantes similares')
            ->assertSee('Operador de almacén');
    }

    /**
     * La página Busco empleo conserva los pasos principales del legacy.
     */
    public function test_job_seeker_page_loads(): void
    {
        $this->get('/busco_empleo')
            ->assertOk()
            ->assertSee('Encuentra el trabajo que quieres')
            ->assertSee('Regístrate y crea tu CV con nosotros')
            ->assertSee('Descubre vacantes de acuerdo a tus intereses')
            ->assertSee('Postúlate y conecta con reclutadores')
            ->assertSee('Empezar');
    }

    /**
     * La página Ofrezco empleo conserva las instrucciones principales.
     */
    public function test_employer_page_loads(): void
    {
        $this->get('/ofrezco_empleo')
            ->assertOk()
            ->assertSee('Ofrezco Empleo')
            ->assertSee('Publica Vacantes');
    }

    /**
     * El listado público de empresas respalda el enlace Ver todas del home.
     */
    public function test_companies_page_loads(): void
    {
        $this->seed();

        $this->get('/empresas')
            ->assertOk()
            ->assertSee('Empresas participantes')
            ->assertSee('Manufacturas Lerma');
    }

    /**
     * Los eventos públicos muestran su imagen de publicidad cuando existe.
     */
    public function test_events_show_publicity_image(): void
    {
        $this->seed();

        $this->get('/eventos')
            ->assertOk()
            ->assertSee('Jornada de empleo Lerma')
            ->assertSee('images/brand/evento-empleo-demo.svg');

        $this->get('/eventos/jornada-empleo-lerma-demo')
            ->assertOk()
            ->assertSee('Publicidad de Jornada de empleo Lerma')
            ->assertSee('images/brand/evento-empleo-demo.svg');
    }
}
