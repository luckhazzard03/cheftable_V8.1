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

    public function testSingleInventarioFound()
    {
        // Simular una solicitud AJAX
        $this->request->setMethod('post')->setPost(['idInventario' => 1]);

        // Simular que el modelo retorna un inventario
        $this->inventarioModelMock->method('where')->willReturnSelf();
        $this->inventarioModelMock->method('first')->willReturn([
            'idInventario' => 1,
            'Producto' => 'Producto A',
            'Cantidad' => 10
        ]);

        // Ejecutar el método singleInventario
        $response = $this->controller->singleInventario(1);

        // Verificar que la respuesta es un JSON con el inventario encontrado
        $data = json_decode($response->getBody(), true);
        $this->assertEquals('success', $data['message']);
        $this->assertEquals(ResponseInterface::HTTP_OK, $data['response']);
    }

    public function testSingleInventarioNotFound()
    {
        // Simular una solicitud AJAX
        $this->request->setMethod('post')->setPost(['idInventario' => 999]);

        // Simular que el modelo no encuentra el inventario
        $this->inventarioModelMock->method('where')->willReturnSelf();
        $this->inventarioModelMock->method('first')->willReturn(null);

        // Ejecutar el método singleInventario
        $response = $this->controller->singleInventario(999);

        // Verificar que la respuesta es un JSON con mensaje de error
        $data = json_decode($response->getBody(), true);
        $this->assertEquals('Error al obtener el inventario', $data['message']);
        $this->assertEquals(ResponseInterface::HTTP_NO_CONTENT, $data['response']);
    }
}
