<?php

namespace App\Controllers;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\HTTP\ResponseInterface;

class MenuDiarioTest extends CIUnitTestCase
{
    protected $controller;
    protected $menuDiarioModelMock;
    protected $sessionMock;

    protected function setUp(): void
    {
        parent::setUp();
        $this->controller = new MenuDiario();
        $this->menuDiarioModelMock = $this->createMock(\App\Models\MenuDiarioModel::class);
        $this->sessionMock = $this->createMock(\CodeIgniter\Session\Session::class);

        // Inyectar el mock de la sesión
        $this->controller->session = $this->sessionMock;
        
        // Inyectar el mock del modelo
        $this->controller->menuDiarioModel = $this->menuDiarioModelMock;
    }

    public function testDeleteWithValidId()
    {
        // Simular que la solicitud es AJAX
        $this->request->setMethod('post')->setPost(['id' => 1]);
        $this->controller->request = $this->request;

        // Simular que el modelo elimina correctamente el menú
        $this->menuDiarioModelMock->method('where')->willReturnSelf();
        $this->menuDiarioModelMock->method('delete')->willReturn(true);

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
        $this->menuDiarioModelMock->method('where')->willReturnSelf();
        $this->menuDiarioModelMock->method('delete')->willReturn(false);

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
