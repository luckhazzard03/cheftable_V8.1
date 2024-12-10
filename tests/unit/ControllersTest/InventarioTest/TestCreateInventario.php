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

    public function testCreateInventarioSuccess()
    {
        // Simular una solicitud AJAX con los datos para crear un inventario
        $this->request->setMethod('post')->setPost([
            'Producto' => 'Producto A',
            'Cantidad' => 10,
            'Cantidad_Minima' => 5,
            'idUsuario_fk' => 1,
            'create_at' => '2024-11-27 12:00:00',
            'update_at' => '2024-11-27 12:00:00'
        ]);

        // Simular que el método insert del modelo retorna true
        $this->inventarioModelMock->method('insert')->willReturn(true);

        // Ejecutar el método create
        $response = $this->controller->create();

        // Verificar que la respuesta es un JSON con mensaje de éxito
        $data = json_decode($response->getBody(), true);
        $this->assertEquals('success', $data['message']);
        $this->assertEquals(ResponseInterface::HTTP_OK, $data['response']);
    }

    public function testCreateInventarioFailure()
    {
        // Simular una solicitud AJAX con los datos para crear un inventario
        $this->request->setMethod('post')->setPost([
            'Producto' => 'Producto B',
            'Cantidad' => 20,
            'Cantidad_Minima' => 10,
            'idUsuario_fk' => 2,
            'create_at' => '2024-11-27 12:00:00',
            'update_at' => '2024-11-27 12:00:00'
        ]);

        // Simular que el método insert del modelo retorna false (fallo en la inserción)
        $this->inventarioModelMock->method('insert')->willReturn(false);

        // Ejecutar el método create
        $response = $this->controller->create();

        // Verificar que la respuesta es un JSON con mensaje de error
        $data = json_decode($response->getBody(), true);
        $this->assertEquals('Error al crear el inventario', $data['message']);
        $this->assertEquals(ResponseInterface::HTTP_NO_CONTENT, $data['response']);
    }
}

