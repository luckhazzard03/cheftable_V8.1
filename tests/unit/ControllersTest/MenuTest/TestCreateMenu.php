<?php

namespace App\Controllers;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\HTTP\ResponseInterface;

class MenuTest extends CIUnitTestCase
{
    protected $controller;
    protected $menuModelMock;
    protected $sessionMock;

    protected function setUp(): void
    {
        parent::setUp();
        $this->controller = new Menu();
        $this->menuModelMock = $this->createMock(\App\Models\MenuModel::class);
        $this->sessionMock = $this->createMock(\CodeIgniter\Session\Session::class);

        // Inyectar el mock de la sesión
        $this->controller->session = $this->sessionMock;
        
        // Inyectar el mock del modelo
        $this->controller->MenuModel = $this->menuModelMock;
    }

    public function testCreateWithValidRequest()
    {
        $postData = [
            'Menu_id' => 1,
            'Tipo_Menu' => 'Entrada',
            'Precio_Menu' => 100,
            'create_at' => '2024-01-01 12:00:00',
            'update_at' => '2024-01-02 12:00:00'
        ];

        // Simular que la solicitud es AJAX
        $this->request->setMethod('post')->setPost($postData);
        $this->controller->request = $this->request;

        // Simular que el modelo inserta correctamente
        $this->menuModelMock->method('insert')->willReturn(true);

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
            'message' => 'Error en la solicitud AJAX',
            'response' => ResponseInterface::HTTP_CONFLICT,
            'data' => ''
        ]), $response);
    }
}

