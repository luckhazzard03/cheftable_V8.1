<?php

namespace App\Controllers;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\HTTP\ResponseInterface;

class MenuDiarioTest extends CIUnitTestCase
{
    protected $controller;
    protected $menuDiarioModelMock;
    protected $sessionMock;

    protected function setUp(): void
    {
        parent::setUp();
        $this->controller = new MenuDiario();
        $this->menuDiarioModelMock = $this->createMock(\App\Models\MenuDiarioModel::class);
        $this->sessionMock = $this->createMock(\CodeIgniter\Session\Session::class);

        // Inyectar el mock de la sesión
        $this->controller->session = $this->sessionMock;
        
        // Inyectar el mock del modelo
        $this->controller->menuDiarioModel = $this->menuDiarioModelMock;
    }

    public function testIndexWithValidRole()
    {
        // Simular que el usuario está autenticado y tiene un rol permitido (Admin)
        $this->sessionMock->method('has')->willReturn(true);
        $this->sessionMock->method('get')->willReturn('Admin');

        // Simular que el modelo devuelve una lista de menús
        $this->menuDiarioModelMock->method('orderBy')->willReturnSelf();
        $this->menuDiarioModelMock->method('findAll')->willReturn([
            ['idDiario' => 1, 'Dia' => 'Lunes', 'Descripcion' => 'Descripción del menú', 'Menu_id_fk' => 1]
        ]);

        // Ejecutar el método index
        $response = $this->controller->index();

        // Verificar que la respuesta contiene los datos esperados
        $this->assertStringContainsString('MENUDIARIO', $response);
    }

    public function testIndexWithInvalidRole()
    {
        // Simular que el usuario no tiene un rol permitido
        $this->sessionMock->method('has')->willReturn(true);
        $this->sessionMock->method('get')->willReturn('Cliente');

        // Ejecutar el método index
        $response = $this->controller->index();

        // Verificar que se redirige a la página de login
        $this->assertStringContainsString('/login', $response);
    }
}