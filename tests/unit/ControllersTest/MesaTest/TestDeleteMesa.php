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

    public function testDeleteWithValidId()
    {
        // Simular la solicitud AJAX
        $this->request->setMethod('post')->setPost(['id' => 1]);
        $this->controller->request = $this->request;

        // Simular que el modelo elimina correctamente la mesa
        $this->mesaModelMock->method('where')->willReturnSelf();
        $this->mesaModelMock->method('delete')->willReturn(true);

        // Ejecutar el método delete
        $response = $this->controller->delete(1);

        // Verificar que la respuesta sea la esperada
        $this->assertJsonStringEqualsJsonString(json_encode([
            'message' => 'success',
            'response' => ResponseInterface::HTTP_OK,
            'data' => 'OK',
            'csrf' => csrf_hash()
        ]), $response);
    }

    public function testDeleteWithFailedDeletion()
    {
        // Simular la solicitud AJAX
        $this->request->setMethod('post')->setPost(['id' => 1]);
        $this->controller->request = $this->request;

        // Simular que el modelo no logra eliminar la mesa
        $this->mesaModelMock->method('where')->willReturnSelf();
        $this->mesaModelMock->method('delete')->willReturn(false);

        // Ejecutar el método delete
        $response = $this->controller->delete(1);

        // Verificar que la respuesta sea un error
        $this->assertJsonStringEqualsJsonString(json_encode([
            'message' => 'Error al eliminar la mesa',
            'response' => ResponseInterface::HTTP_NO_CONTENT,
            'data' => ''
        ]), $response);
    }
}
