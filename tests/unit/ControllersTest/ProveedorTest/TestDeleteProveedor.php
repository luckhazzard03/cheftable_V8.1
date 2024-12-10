<?php

namespace App\Controllers;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\HTTP\ResponseInterface;

class ProveedorTest extends CIUnitTestCase
{
    protected $controller;
    protected $proveedorModelMock;

    protected function setUp(): void
    {
        parent::setUp();
        $this->controller = new Proveedor();
        $this->proveedorModelMock = $this->createMock(\App\Models\ProveedorModel::class);
        
        // Inyectar el mock del modelo
        $this->controller->proveedorModel = $this->proveedorModelMock;
    }

    public function testDeleteWithValidId()
    {
        // Simular la solicitud AJAX con el ID de un proveedor
        $this->request->setMethod('post')->setPost(['id' => 1]);
        $this->controller->request = $this->request;

        // Simular que el modelo elimina correctamente el proveedor
        $this->proveedorModelMock->method('where')->willReturnSelf();
        $this->proveedorModelMock->method('delete')->willReturn(true);

        // Ejecutar el método delete()
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
        // Simular la solicitud AJAX con el ID de un proveedor
        $this->request->setMethod('post')->setPost(['id' => 1]);
        $this->controller->request = $this->request;

        // Simular que el modelo falla al eliminar el proveedor
        $this->proveedorModelMock->method('where')->willReturnSelf();
        $this->proveedorModelMock->method('delete')->willReturn(false);

        // Ejecutar el método delete()
        $response = $this->controller->delete(1);

        // Verificar que la respuesta de error se devuelva
        $this->assertJsonStringEqualsJsonString(json_encode([
            'message' => 'Error al eliminar el proveedor',
            'response' => ResponseInterface::HTTP_NO_CONTENT,
            'data' => ''
        ]), $response);
    }

    public function testDeleteWithException()
    {
        // Simular que ocurre una excepción durante la eliminación
        $this->request->setMethod('post')->setPost(['id' => 1]);
        $this->controller->request = $this->request;

        // Configurar el mock para lanzar una excepción
        $this->proveedorModelMock->method('where')->willReturnSelf();
        $this->proveedorModelMock->method('delete')->will($this->throwException(new \Exception('Error al eliminar')));

        // Ejecutar el método delete()
        $response = $this->controller->delete(1);

        // Verificar que la respuesta de error por excepción se devuelva
        $this->assertJsonStringEqualsJsonString(json_encode([
            'message' => 'Error al eliminar el proveedor',
            'response' => ResponseInterface::HTTP_CONFLICT,
            'data' => ''
        ]), $response);
    }
}
