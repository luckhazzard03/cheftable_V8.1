<?php

namespace App\Controllers;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\HTTP\ResponseInterface;

class LoginTest extends CIUnitTestCase
{
    protected $controller;

    protected function setUp(): void
    {
        parent::setUp();
        $this->controller = new Login();
    }

    public function testIndex()
    {
        // Ejecutar el método index
        $response = $this->controller->index();

        // Verificar que la respuesta es la vista de login
        $this->assertStringContainsString('login', $response);
    }
}