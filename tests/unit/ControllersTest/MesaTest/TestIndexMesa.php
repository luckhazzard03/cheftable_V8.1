<?php

namespace App\Controllers;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\HTTP\ResponseInterface;

class MesaTest extends CIUnitTestCase
{
    protected $controller;
    protected $mesaModelMock;
    protected $sessionMock;

    protected function setUp(): void
    {
        parent::setUp();
        $this->controller = new Mesa();
        $this->mesaModelMock = $this->createMock(\App\Models\MesaModel::class);
        $this->sessionMock = $this->createMock(\CodeIgniter\Session\Session::class);

        // Inyectar el mock de la sesión
        $this->controller->session = $this->sessionMock;
        
        // Inyectar el mock del modelo
        $this->controller->mesaModel = $this->mesaModelMock;
    }

    public function testIndexWithValidRole()
    {
        // Simular que el rol del usuario es 'Admin'
        $this->sessionMock->method('get')->willReturn('Admin');

        // Simular que el modelo devuelve una lista de mesas
        $this->mesaModelMock->method('orderBy')->willReturnSelf();
        $this->mesaModelMock->method('findAll')->willReturn([
            ['idMesa' => 1, 'No_Orden' => 123, 'Estado' => 'Disponible', 'Capacidad' => 4]
        ]);

        // Ejecutar el método index
        $response = $this->controller->index();

        // Verificar que la respuesta contenga las mesas
        $this->assertStringContainsString('MESAS', $response);
    }

    public function testIndexWithInvalidRole()
    {
        // Simular que el rol del usuario es 'Cliente' (un rol no permitido)
        $this->sessionMock->method('get')->willReturn('Cliente');

        // Ejecutar el método index
        $response = $this->controller->index();

        // Verificar que el usuario fue redirigido a la página de login
        $this->assertStringContainsString('/login', $response);
    }
}

