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

    public function testCreateComandaMenuSuccess()
    {
        // Simular una sesión con rol 'Chef'
        session()->set([
            'user_id' => 1,
            'role' => 'Chef'
        ]);

        // Simular que la solicitud es AJAX
        $this->request->setMethod('post')->setPost([
            'Comanda_menu_id' => 1,
            'Cantidad_Menu' => 3,
            'Precio' => 50,
            'Descripcion' => 'Menú 1',
            'Comanda_fk' => 1,
            'Menu_fk' => 1,
        ]);

        // Simular que el modelo insert retorna true
        $this->comandaMenuModelMock->method('insert')->willReturn(true);

        // Ejecutar el método create
        $response = $this->controller->create();

        // Verificar que la respuesta es un JSON con mensaje de éxito
        $data = json_decode($response->getBody(), true);
        $this->assertEquals('success', $data['message']);
        $this->assertEquals(ResponseInterface::HTTP_OK, $data['response']);
    }

    public function testCreateComandaMenuFailure()
    {
        // Simular una sesión con rol 'Chef'
        session()->set([
            'user_id' => 1,
            'role' => 'Chef'
        ]);

        // Simular que la solicitud es AJAX
        $this->request->setMethod('post')->setPost([
            'Comanda_menu_id' => 1,
            'Cantidad_Menu' => 3,
            'Precio' => 50,
            'Descripcion' => 'Menú 1',
            'Comanda_fk' => 1,
            'Menu_fk' => 1,
        ]);

        // Simular que el modelo insert retorna false
        $this->comandaMenuModelMock->method('insert')->willReturn(false);

        // Ejecutar el método create
        $response = $this->controller->create();

        // Verificar que la respuesta es un JSON con mensaje de error
        $data = json_decode($response->getBody(), true);
        $this->assertEquals('Error creando la comanda', $data['message']);
        $this->assertEquals(ResponseInterface::HTTP_NO_CONTENT, $data['response']);
    }

    public function testCreateComandaMenuAccessDenied()
    {
        // Simular una sesión con rol no permitido (solo Admin, Chef, Mesero)
        session()->set([
            'user_id' => 1,
            'role' => 'Cliente'
        ]);

        // Ejecutar el método create
        $response = $this->controller->create();

        // Verificar que la respuesta es un JSON con mensaje de acceso denegado
        $data = json_decode($response->getBody(), true);
        $this->assertEquals('Acceso denegado', $data['message']);
        $this->assertEquals(ResponseInterface::HTTP_FORBIDDEN, $data['response']);
    }
}
?>


