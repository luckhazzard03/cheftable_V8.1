<?php

namespace App\Controllers;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\HTTP\ResponseInterface;

class ComandaTest extends CIUnitTestCase
{
    protected $controller;
    protected $comandaModelMock;

    protected function setUp(): void
    {
        parent::setUp();
        $this->controller = new Comanda();
        $this->comandaModelMock = $this->createMock(\App\Models\ComandaModel::class);
        $this->controller->comandaModel = $this->comandaModelMock;
    }

    public function testUpdateComandaSuccess()
    {
        // Simular una solicitud AJAX para actualizar una comanda
        $this->request->setMethod('post')->setPost([
            'Comanda_id' => 1,
            'Fecha' => '2024-11-27',
            'Hora' => '12:00:00',
            'Total_platos' => 3,
            'Precio_Total' => 100.00,
            'Tipo_Menu' => 'Menú A',
            'idUsuario_fk' => 1,
            'idMesa_fk' => 5
        ]);

        // Simular que el modelo update retorna true
        $this->comandaModelMock->method('update')->willReturn(true);

        // Ejecutar el método update
        $response = $this->controller->update();

        // Verificar que la respuesta es un JSON con mensaje de éxito
        $data = json_decode($response->getBody(), true);
        $this->assertEquals('success', $data['message']);
        $this->assertEquals(ResponseInterface::HTTP_OK, $data['response']);
    }

    public function testUpdateComandaFailure()
    {
        // Simular una solicitud AJAX para actualizar una comanda
        $this->request->setMethod('post')->setPost([
            'Comanda_id' => 1,
            'Fecha' => '2024-11-27',
            'Hora' => '12:00:00',
            'Total_platos' => 3,
            'Precio_Total' => 100.00,
            'Tipo_Menu' => 'Menú A',
            'idUsuario_fk' => 1,
            'idMesa_fk' => 5
        ]);

        // Simular que el modelo update retorna false
        $this->comandaModelMock->method('update')->willReturn(false);

        // Ejecutar el método update
        $response = $this->controller->update();

        // Verificar que la respuesta es un JSON con mensaje de error
        $data = json_decode($response->getBody(), true);
        $this->assertEquals('Error create user', $data['message']);
        $this->assertEquals(ResponseInterface::HTTP_NO_CONTENT, $data['response']);
    }
}

