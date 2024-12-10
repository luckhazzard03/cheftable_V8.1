<?php

namespace App\Controllers;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\HTTP\ResponseInterface;

class ComandaTest extends CIUnitTestCase
{
    protected $controller;
    
    protected function setUp(): void
    {
        parent::setUp();
        $this->controller = new Comanda();
    }

    public function testIndexWithValidSessionAndRole()
    {
        // Simular una sesión activa con rol 'Mesero'
        session()->set([
            'user_id' => 1,
            'role' => 'Mesero'
        ]);

        // Ejecutar el método index
        $response = $this->controller->index();

        // Verificar que la respuesta contiene el título 'COMANDA'
        $this->assertStringContainsString('COMANDA', $response);
    }

    public function testIndexWithInvalidRole()
    {
        // Simular una sesión activa con rol 'Cliente' (no permitido)
        session()->set([
            'user_id' => 1,
            'role' => 'Cliente'
        ]);

        // Ejecutar el método index
        $response = $this->controller->index();

        // Verificar que la respuesta es una redirección al login
        $this->assertRedirects($response, base_url('login'));
    }

    public function testIndexWithoutSession()
    {
        // No establecer sesión
        session()->remove('user_id');

        // Ejecutar el método index
        $response = $this->controller->index();

        // Verificar que la respuesta es una redirección al login
        $this->assertRedirects($response, base_url('login'));
    }
}
