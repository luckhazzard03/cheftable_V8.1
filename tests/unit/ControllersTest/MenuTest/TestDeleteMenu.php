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

    public function testDeleteWithValidId()
    {
        // Simular que la solicitud es AJAX
        $this->request->setMethod('post')->setPost(['id' => 1]);
        $this->controller->request = $this->request;

        // Simular que el modelo elimina correctamente el menú
        $this->menuModelMock->method('where')->willReturnSelf();
        $this->menuModelMock->method('delete')->willReturn(true);

        // Ejecutar el método delete
        $response = $this->controller->delete(1);

        // Verificar que la respuesta sea correcta
        $this->assertJsonStringEqualsJsonString(json_encode([
            'message' => 'success',
            'response' => ResponseInterface::HTTP_OK,
            'data' => "OK",
            'csrf' => csrf_hash()
        ]), $response);
    }

    public function testDeleteWithInvalidId()
    {
        // Simular que la solicitud es AJAX
        $this->request->setMethod('post')->setPost(['id' => 1]);
        $this->controller->request = $this->request;

        // Simular que el modelo no logra eliminar el menú
        $this->menuModelMock->method('where')->willReturnSelf();
        $this->menuModelMock->method('delete')->willReturn(false);

        // Ejecutar el método delete
        $response = $this->controller->delete(1);

        // Verificar que la respuesta sea un error
        $this->assertJsonStringEqualsJsonString(json_encode([
            'message' => 'Error create user',
            'response' => ResponseInterface::HTTP_NO_CONTENT,
            'data' => ''
        ]), $response);
    }
}
