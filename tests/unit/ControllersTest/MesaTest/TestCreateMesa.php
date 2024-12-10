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

    public function testCreateWithValidRequest()
    {
        $postData = [
            'idMesa' => 1,
            'No_Orden' => 123,
            'Estado' => 'Disponible',
            'Capacidad' => 4,
            'create_at' => '2024-01-01 12:00:00',
            'update_at' => '2024-01-02 12:00:00'
        ];

        // Simular la solicitud AJAX
        $this->request->setMethod('post')->setPost($postData);
        $this->controller->request = $this->request;

        // Simular que el modelo inserta correctamente
        $this->mesaModelMock->method('insert')->willReturn(true);

        // Ejecutar el método create
        $response = $this->controller->create();

        // Verificar que la respuesta sea un JSON con 'success'
        $this->assertJsonStringEqualsJsonString(json_encode([
            'message' => 'success',
            'response' => ResponseInterface::HTTP_OK,
            'data' => $postData,
            'csrf' => csrf_hash()
        ]), $response);
    }

    public function testCreateWithInvalidRequest()
    {
        // Simular que no es una solicitud AJAX
        $this->request->setMethod('post');
        $this->controller->request = $this->request;

        // Ejecutar el método create
        $response = $this->controller->create();

        // Verificar que la respuesta sea un error
        $this->assertJsonStringEqualsJsonString(json_encode([
            'message' => 'Error Ajax',
            'response' => ResponseInterface::HTTP_CONFLICT,
            'data' => ''
        ]), $response);
    }
}
