
<?php

namespace App\Controllers;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\HTTP\ResponseInterface;

class ComandaMenuTest extends CIUnitTestCase
{
    protected $controller;
    protected $comandaMenuModelMock;

    protected function setUp(): void
    {
        parent::setUp();
        $this->controller = new ComandaMenu();
        $this->comandaMenuModelMock = $this->createMock(\App\Models\ComandaMenuModel::class);
        $this->controller->ComandaMenuModel = $this->comandaMenuModelMock;
    }

    public function testIndexWithValidRole()
    {
        // Simular una sesión con rol 'Chef'
        session()->set([
            'user_id' => 1,
            'role' => 'Chef'
        ]);

        // Simular que el modelo retorna datos de la comanda
        $this->comandaMenuModelMock->method('orderBy')->willReturnSelf();
        $this->comandaMenuModelMock->method('findAll')->willReturn([
            ['Comanda_menu_id' => 1, 'Cantidad_Menu' => 3, 'Precio' => 50, 'Descripcion' => 'Menú 1'],
        ]);

        // Ejecutar el método index
        $response = $this->controller->index();

        // Verificar que la respuesta contiene los datos de la comanda
        $this->assertStringContainsString('COMANDAS MENU', $response);
        $this->assertStringContainsString('Menú 1', $response);
    }

    public function testIndexWithInvalidRole()
    {
        // Simular una sesión con rol 'Cliente' (no permitido)
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
?>
