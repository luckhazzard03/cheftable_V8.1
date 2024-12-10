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

    public function testUpdateInventarioSuccess()
    {
        // Simular una solicitud AJAX con datos de actualización
        $this->request->setMethod('post')->setPost([
            'idInventario' => 1,
            'Producto' => 'Producto A',
            'Cantidad' => 15,
            'Cantidad_Minima' => 5,
            'idUsuario_fk' => 1,
            'create_at' => '2024-11-27 12:00:00',
            'update_at' => '2024-11-27 12:00:00'
        ]);

        // Simular que el modelo update retorna true (actualización exitosa)
        $this->inventarioModelMock->method('update')->willReturn(true);

        // Ejecutar el método update
        $response = $this->controller->update();

        // Verificar que la respuesta es un JSON con mensaje de éxito
        $data = json_decode($response->getBody(), true);
        $this->assertEquals('success', $data['message']);
        $this->assertEquals(ResponseInterface::HTTP_OK, $data['response']);
    }

    public function testUpdateInventarioFailure()
    {
        // Simular una solicitud AJAX con datos de actualización
        $this->request->setMethod('post')->setPost([
            'idInventario' => 1,
            'Producto' => 'Producto B',
            'Cantidad' => 10,
            'Cantidad_Minima' => 3,
            'idUsuario_fk' => 1,
            'create_at' => '2024-11-27 12:00:00',
            'update_at' => '2024-11-27 12:00:00'
        ]);

        // Simular que el modelo update retorna false (fallo en la actualización)
        $this->inventarioModelMock->method('update')->willReturn(false);

        // Ejecutar el método update
        $response = $this->controller->update();

        // Verificar que la respuesta es un JSON con mensaje de error
        $data = json_decode($response->getBody(), true);
        $this->assertEquals('Error al actualizar el inventario', $data['message']);
        $this->assertEquals(ResponseInterface::HTTP_NO_CONTENT, $data['response']);
    }
}
