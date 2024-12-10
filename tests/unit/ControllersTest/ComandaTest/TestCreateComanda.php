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

    public function testCreateComandaSuccess()
    {
        // Simular una solicitud AJAX con los datos para crear una comanda
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

        // Simular que el método insert del modelo retorna true
        $this->comandaModelMock->method('insert')->willReturn(true);

        // Ejecutar el método create
        $response = $this->controller->create();

        // Verificar que la respuesta es un JSON con mensaje de éxito
        $data = json_decode($response->getBody(), true);
        $this->assertEquals('success', $data['message']);
        $this->assertEquals(ResponseInterface::HTTP_OK, $data['response']);
    }

    public function testCreateComandaFailure()
    {
        // Simular una solicitud AJAX con los datos para crear una comanda
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

        // Simular que el método insert del modelo retorna false
        $this->comandaModelMock->method('insert')->willReturn(false);

        // Ejecutar el método create
        $response = $this->controller->create();

        // Verificar que la respuesta es un JSON con mensaje de error
        $data = json_decode($response->getBody(), true);
        $this->assertEquals('Error creando la comanda', $data['message']);
        $this->assertEquals(ResponseInterface::HTTP_NO_CONTENT, $data['response']);
    }

    public function testCreateComandaAccessDenied()
    {
        // Simular una solicitud AJAX con el rol no permitido (solo Admin, Chef, Mesero pueden)
        session()->set([
            'user_id' => 1,
            'role' => 'Cliente'
        ]);

        $response = $this->controller->create();

        // Verificar que la respuesta es un JSON con mensaje de acceso denegado
        $data = json_decode($response->getBody(), true);
        $this->assertEquals('Acceso denegado', $data['message']);
        $this->assertEquals(ResponseInterface::HTTP_FORBIDDEN, $data['response']);
    }
}
