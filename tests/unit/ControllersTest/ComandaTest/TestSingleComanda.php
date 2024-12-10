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

    public function testSingleComandaFound()
    {
        // Simular una solicitud AJAX
        $this->request->setMethod('post')->setPost(['Comanda_id' => 1]);

        // Simular que el modelo retorna una comanda
        $this->comandaModelMock->method('where')->willReturnSelf();
        $this->comandaModelMock->method('first')->willReturn([
            'Comanda_id' => 1,
            'Fecha' => '2024-11-27',
            'Hora' => '12:00:00',
            'Total_platos' => 3,
            'Precio_Total' => 100.00
        ]);

        // Ejecutar el método singleComanda
        $response = $this->controller->singleComanda(1);

        // Verificar que la respuesta contiene los datos de la comanda
        $data = json_decode($response->getBody(), true);
        $this->assertEquals('success', $data['message']);
        $this->assertEquals(ResponseInterface::HTTP_OK, $data['response']);
    }

    public function testSingleComandaNotFound()
    {
        // Simular una solicitud AJAX
        $this->request->setMethod('post')->setPost(['Comanda_id' => 999]);

        // Simular que el modelo no encuentra la comanda
        $this->comandaModelMock->method('where')->willReturnSelf();
        $this->comandaModelMock->method('first')->willReturn(null);

        // Ejecutar el método singleComanda
        $response = $this->controller->singleComanda(999);

        // Verificar que la respuesta contiene mensaje de error
        $data = json_decode($response->getBody(), true);
        $this->assertEquals('Error create user', $data['message']);
        $this->assertEquals(ResponseInterface::HTTP_NO_CONTENT, $data['response']);
    }
}

