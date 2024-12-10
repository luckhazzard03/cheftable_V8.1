
<?php

namespace App\Controllers;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\HTTP\ResponseInterface;

class MenuTest extends CIUnitTestCase
{
    protected $controller;
    protected $menuModelMock;
    protected $sessionMock;

    protected function setUp(): void
    {
        parent::setUp();
        $this->controller = new Menu();
        $this->menuModelMock = $this->createMock(\App\Models\MenuModel::class);
        $this->sessionMock = $this->createMock(\CodeIgniter\Session\Session::class);

        // Inyectar el mock de la sesión
        $this->controller->session = $this->sessionMock;
        
        // Inyectar el mock del modelo
        $this->controller->MenuModel = $this->menuModelMock;
    }

    public function testIndexWithValidRole()
    {
        // Simular que el usuario está autenticado y tiene un rol permitido (Admin)
        $this->sessionMock->method('has')->willReturn(true);
        $this->sessionMock->method('get')->willReturn('Admin');

        // Simular que el modelo devuelve una lista de menús
        $this->menuModelMock->method('orderBy')->willReturnSelf();
        $this->menuModelMock->method('findAll')->willReturn([
            ['Menu_id' => 1, 'Tipo_Menu' => 'Entrada', 'Precio_Menu' => 100]
        ]);

        // Ejecutar el método index
        $response = $this->controller->index();

        // Verificar que la respuesta contiene los datos esperados
        $this->assertStringContainsString('MENUS', $response);
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