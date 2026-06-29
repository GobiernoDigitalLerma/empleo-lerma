<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Prueba base de disponibilidad del home público.
 */
class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Confirma que la aplicación responde después de cargar seeders.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $this->seed();

        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
