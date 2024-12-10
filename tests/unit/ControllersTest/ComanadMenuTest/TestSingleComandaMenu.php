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

    public function testSingleComandaMenuFound()
    {
        // Simular una sesión con rol 'Chef'
        session()->set([
            'user_id' => 1,
            'role' => 'Chef'
        ]);

        // Simular que la solicitud es AJAX
        $this->request->setMethod('post')->setPost(['Comanda_menu_id' => 1]);

        // Simular que el modelo encuentra una comanda
        $this->comandaMenuModelMock->method('where')->willReturnSelf();
        $this->comandaMenuModelMock->method('first')->willReturn([
            'Comanda_menu_id' => 1,
            'Cantidad_Menu' => 3,
            'Precio' => 50,
            'Descripcion' => 'Menú 1',
        ]);

        // Ejecutar el método singleComandaMenu
        $response = $this->controller->singleComandaMenu(1);

        // Verificar que la respuesta contiene los datos de la comanda
        $data = json_decode($response->getBody(), true);
        $this->assertEquals('success', $data['message']);
        $this->assertEquals(ResponseInterface::HTTP_OK, $data['response']);
    }

    public function testSingleComandaMenuNotFound()
    {
        // Simular una sesión con rol 'Chef'
        session()->set([
            'user_id' => 1,
            'role' => 'Chef'
        ]);

        // Simular que la solicitud es AJAX
        $this->request->setMethod('post')->setPost(['Comanda_menu_id' => 999]);

        // Simular que el modelo no encuentra la comanda
        $this->comandaMenuModelMock->method('where')->willReturnSelf();
        $this->comandaMenuModelMock->method('first')->willReturn(null);

        // Ejecutar el método singleComandaMenu
        $response = $this->controller->singleComandaMenu(999);

        // Verificar que la respuesta es un JSON con mensaje de error
        $data = json_decode($response->getBody(), true);
        $this->assertEquals('Error al obtener la comanda', $data['message']);
        $this->assertEquals(ResponseInterface::HTTP_NO_CONTENT, $data['response']);
    }
}
?>

