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

    public function testDeleteComandaMenuSuccess()
    {
        // Simular una sesión con rol 'Chef'
        session()->set([
            'user_id' => 1,
            'role' => 'Chef'
        ]);

        // Simular que el modelo delete retorna true
        $this->comandaMenuModelMock->method('where')->willReturnSelf();
        $this->comandaMenuModelMock->method('delete')->willReturn(true);

        // Ejecutar el método delete
        $response = $this->controller->delete(1);

        // Verificar que la respuesta es un JSON con mensaje de éxito
        $data = json_decode($response->getBody(), true);
        $this->assertEquals('success', $data['message']);
        $this->assertEquals(ResponseInterface::HTTP_OK, $data['response']);
    }

    public function testDeleteComandaMenuFailure()
    {
        // Simular una sesión con rol 'Chef'
        session()->set([
            'user_id' => 1,
            'role' => 'Chef'
        ]);

        // Simular que el modelo delete retorna false
        $this->comandaMenuModelMock->method('where')->willReturnSelf();
        $this->comandaMenuModelMock->method('delete')->willReturn(false);

        // Ejecutar el método delete
        $response = $this->controller->delete(1);

        // Verificar que la respuesta es un JSON con mensaje de error
        $data = json_decode($response->getBody(), true);
        $this->assertEquals('Error eliminando la comanda', $data['message']);
        $this->assertEquals(ResponseInterface::HTTP_NO_CONTENT, $data['response']);
    }
}
?>


