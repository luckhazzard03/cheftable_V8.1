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

    public function testSingleProveedorFound()
    {
        // Simular la solicitud AJAX
        $this->request->setMethod('post')->setPost(['id' => 1]);
        $this->controller->request = $this->request;

        // Simular la consulta de un proveedor
        $this->proveedorModelMock->method('where')->willReturnSelf();
        $this->proveedorModelMock->method('first')->willReturn(['idProveedor' => 1, 'Nombre' => 'Proveedor 1']);

        // Ejecutar el método
        $response = $this->controller->singleProveedor(1);

        // Verificar que la respuesta sea correcta
        $this->assertJsonStringEqualsJsonString(json_encode([
            'message' => 'success',
            'response' => ResponseInterface::HTTP_OK,
            'data' => ['idProveedor' => 1, 'Nombre' => 'Proveedor 1'],
            'csrf' => csrf_hash()
        ]), $response);
    }

    public function testSingleProveedorNotFound()
    {
        // Simular que no se encuentra el proveedor
        $this->proveedorModelMock->method('where')->willReturnSelf();
        $this->proveedorModelMock->method('first')->willReturn(null);

        // Ejecutar el método
        $response = $this->controller->singleProveedor(999);

        // Verificar que la respuesta sea de error
        $this->assertJsonStringEqualsJsonString(json_encode([
            'message' => 'Proveedor no encontrado',
            'response' => ResponseInterface::HTTP_NO_CONTENT,
            'data' => ''
        ]), $response);
    }
}