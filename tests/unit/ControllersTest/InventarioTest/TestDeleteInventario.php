<?php

namespace App\Controllers;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\HTTP\ResponseInterface;

class InventarioTest extends CIUnitTestCase
{
    protected $controller;
    protected $inventarioModelMock;

    protected function setUp(): void
    {
        parent::setUp();
        $this->controller = new Inventario();
        $this->inventarioModelMock = $this->createMock(\App\Models\InventarioModel::class);
        $this->controller->inventarioModel = $this->inventarioModelMock;
    }

    public function testDeleteInventarioSuccess()
    {
        // Simular que el modelo delete retorna true (eliminación exitosa)
        $this->inventarioModelMock->method('delete')->willReturn(true);

        // Ejecutar el método delete
        $response = $this->controller->delete(1);

        // Verificar que la respuesta es un JSON con mensaje de éxito
        $data = json_decode($response->getBody(), true);
        $this->assertEquals('success', $data['message']);
        $this->assertEquals(ResponseInterface::HTTP_OK, $data['response']);
    }

    public function testDeleteInventarioFailure()
    {
        // Simular que el modelo delete retorna false (fallo en la eliminación)
        $this->inventarioModelMock->method('delete')->willReturn(false);

        // Ejecutar el método delete
        $response = $this->controller->delete(1);

        // Verificar que la respuesta es un JSON con mensaje de error
        $data = json_decode($response->getBody(), true);
        $this->assertEquals('Error al eliminar el inventario', $data['message']);
        $this->assertEquals(ResponseInterface::HTTP_NO_CONTENT, $data['response']);
    }
}
