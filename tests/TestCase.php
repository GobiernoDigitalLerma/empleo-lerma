<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

/**
 * Base común para pruebas de Laravel.
 */
abstract class TestCase extends BaseTestCase
{
    /**
     * Desactiva Vite en tests para no depender del manifest de assets.
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();
    }
}
