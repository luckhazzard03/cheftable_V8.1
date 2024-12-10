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

    public function testSingleMenuWithValidId()
    {
        // Simular que la solicitud es AJAX
        $this->request->setMethod('post');
        $this->controller->request = $this->request;

        // Simular que el modelo encuentra un menú
        $this->menuModelMock->method('where')->willReturnSelf();
        $this->menuModelMock->method('first')->willReturn(['Menu_id' => 1, 'Tipo_Menu' => 'Entrada', 'Precio_Menu' => 100]);

        // Ejecutar el método singleMenu
        $response = $this->controller->singleMenu(1);

        // Verificar que la respuesta sea correcta
        $this->assertJsonStringEqualsJsonString(json_encode([
            'message' => 'success',
            'response' => ResponseInterface::HTTP_OK,
            'data' => ['Menu_id' => 1, 'Tipo_Menu' => 'Entrada', 'Precio_Menu' => 100],
            'csrf' => csrf_hash()
        ]), $response);
    }

    public function testSingleMenuWithInvalidId()
    {
        // Simular que la solicitud es AJAX
        $this->request->setMethod('post');
        $this->controller->request = $this->request;

        // Simular que el modelo no encuentra el menú
        $this->menuModelMock->method('where')->willReturnSelf();
        $this->menuModelMock->method('first')->willReturn(null);

        // Ejecutar el método singleMenu
        $response = $this->controller->singleMenu(999);

        // Verificar que la respuesta sea un error
        $this->assertJsonStringEqualsJsonString(json_encode([
            'message' => 'Error create user',
            'response' => ResponseInterface::HTTP_NO_CONTENT,
            'data' => ''
        ]), $response);
    }
}

