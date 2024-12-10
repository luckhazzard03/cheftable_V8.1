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

    public function testUpdateComandaMenuSuccess()
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
        ]);

        // Simular que el modelo update retorna true
        $this->comandaMenuModelMock->method('update')->willReturn(true);

        // Ejecutar el método update
        $response = $this->controller->update();

        // Verificar que la respuesta es un JSON con mensaje de éxito
        $data = json_decode($response->getBody(), true);
        $this->assertEquals('success', $data['message']);
        $this->assertEquals(ResponseInterface::HTTP_OK, $data['response']);
    }

    public function testUpdateComandaMenuFailure()
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
        ]);

        // Simular que el modelo update retorna false
        $this->comandaMenuModelMock->method('update')->willReturn(false);

        // Ejecutar el método update
        $response = $this->controller->update();

        // Verificar que la respuesta es un JSON con mensaje de error
        $data = json_decode($response->getBody(), true);
        $this->assertEquals('Error actualizando la comanda', $data['message']);
        $this->assertEquals(ResponseInterface::HTTP_NO_CONTENT, $data['response']);
    }
}
?>


