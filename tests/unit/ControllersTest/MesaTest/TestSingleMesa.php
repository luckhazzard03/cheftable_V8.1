<?php

namespace App\Controllers;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\HTTP\ResponseInterface;

class MesaTest extends CIUnitTestCase
{
    protected $controller;
    protected $mesaModelMock;
    protected $sessionMock;

    protected function setUp(): void
    {
        parent::setUp();
        $this->controller = new Mesa();
        $this->mesaModelMock = $this->createMock(\App\Models\MesaModel::class);
        $this->sessionMock = $this->createMock(\CodeIgniter\Session\Session::class);

        // Inyectar el mock de la sesión
        $this->controller->session = $this->sessionMock;
        
        // Inyectar el mock del modelo
        $this->controller->mesaModel = $this->mesaModelMock;
    }

    public function testSingleMesaWithValidId()
    {
        // Simular que la solicitud es AJAX
        $this->request->setMethod('post');
        $this->controller->request = $this->request;

        // Simular que el modelo encuentra una mesa
        $this->mesaModelMock->method('where')->willReturnSelf();
        $this->mesaModelMock->method('first')->willReturn(['idMesa' => 1, 'No_Orden' => 123, 'Estado' => 'Disponible', 'Capacidad' => 4]);

        // Ejecutar el método singleMesa
        $response = $this->controller->singleMesa(1);

        // Verificar que la respuesta sea correcta
        $this->assertJsonStringEqualsJsonString(json_encode([
            'message' => 'success',
            'response' => ResponseInterface::HTTP_OK,
            'data' => ['idMesa' => 1, 'No_Orden' => 123, 'Estado' => 'Disponible', 'Capacidad' => 4],
            'csrf' => csrf_hash()
        ]), $response);
    }

    public function testSingleMesaWithInvalidId()
    {
        // Simular que la solicitud es AJAX
        $this->request->setMethod('post');
        $this->controller->request = $this->request;

        // Simular que el modelo no encuentra la mesa
        $this->mesaModelMock->method('where')->willReturnSelf();
        $this->mesaModelMock->method('first')->willReturn(null);

        // Ejecutar el método singleMesa
        $response = $this->controller->singleMesa(999);

        // Verificar que la respuesta sea un error
        $this->assertJsonStringEqualsJsonString(json_encode([
            'message' => 'Error al obtener la mesa',
            'response' => ResponseInterface::HTTP_NO_CONTENT,
            'data' => ''
        ]), $response);
    }
}