<?php

namespace App\Controllers;

use CodeIgniter\Test\CIUnitTestCase;

class LoginTest extends CIUnitTestCase
{
    protected $controller;

    protected function setUp(): void
    {
        parent::setUp();
        $this->controller = new Login();
    }

    public function testLogout()
    {
        // Simular que hay datos en la sesión
        session()->set([
            'user_id' => 1,
            'email' => 'test@example.com',
            'role' => 'Admin',
        ]);

        // Ejecutar el método logout
        $response = $this->controller->logout();

        // Verificar que la sesión haya sido eliminada
        $this->assertFalse(session()->has('user_id'));
        $this->assertFalse(session()->has('email'));
        $this->assertFalse(session()->has('role'));

        // Verificar que la respuesta sea una redirección al login
        $this->assertRedirects($response, base_url('login'));
    }
}
