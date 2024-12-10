<?php

namespace App\Controllers;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\I18n\Time;
use CodeIgniter\Config\Services;

class ProveedorTest extends CIUnitTestCase
{
    protected $controller;
    protected $sessionMock;
    protected $proveedorModelMock;

    protected function setUp(): void
    {
        parent::setUp();
        $this->controller = new Proveedor();
        $this->sessionMock = $this->createMock(\CodeIgniter\Session\Session::class);
        $this->proveedorModelMock = $this->createMock(\App\Models\ProveedorModel::class);
        
        // Inyectar el mock de sesión
        $this->controller->session = $this->sessionMock;
    }

    public function testIndexWithValidUserRole()
    {
        // Simular una sesión activa con rol 'Admin'
        $this->sessionMock->method('has')->willReturn(true);
        $this->sessionMock->method('get')->willReturn('Admin');

        // Simular la llamada al modelo para obtener proveedores
        $this->proveedorModelMock->method('orderBy')->willReturnSelf();
        $this->proveedorModelMock->method('findAll')->willReturn([
            ['idProveedor' => 1, 'Nombre' => 'Proveedor 1'],
            ['idProveedor' => 2, 'Nombre' => 'Proveedor 2']
        ]);

        // Llamar al método index()
        $response = $this->controller->index();
        
        // Comprobar que la respuesta contiene la vista y los datos esperados
        $this->assertStringContainsString('PROVEEDOR', $response);
    }

    public function testIndexWithInvalidRole()
    {
        // Simular una sesión con un rol no permitido
        $this->sessionMock->method('has')->willReturn(true);
        $this->sessionMock->method('get')->willReturn('Cliente');

        // Ejecutar el método index()
        $response = $this->controller->index();

        // Verificar que redirige a login
        $this->assertStringContainsString('redirect', (string) $response);
    }
}
