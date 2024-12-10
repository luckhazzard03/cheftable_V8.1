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

    public function testCreateWithValidRequest()
    {
        $postData = [
            'Nombre' => 'Nuevo Proveedor',
            'Direccion' => 'Direccion Proveedor',
            'Telefono' => '123456789',
            'Tipo' => 'Proveedor',
            'idUsuario_fk' => 1,
            'create_at' => '2024-01-01 12:00:00',
            'update_at' => '2024-01-01 12:00:00'
        ];

        // Simular la solicitud AJAX
        $this->request->setMethod('post')->setPost($postData);
        $this->controller->request = $this->request;

        // Simular que el modelo insertó correctamente
        $this->proveedorModelMock->method('insert')->willReturn(true);

        // Ejecutar el método create()
        $response = $this->controller->create();

        // Verificar la respuesta
        $this->assertJsonStringEqualsJsonString(json_encode([
            'message' => 'success',
            'response' => ResponseInterface::HTTP_OK,
            'data' => $postData,
            'csrf' => csrf_hash()
        ]), $response);
    }

    public function testCreateWithInvalidRequest()
    {
        // Simular que no se realiza una solicitud AJAX
        $this->request->setMethod('post');
        $this->controller->request = $this->request;

        // Ejecutar el método create()
        $response = $this->controller->create();

        // Verificar la respuesta de error
        $this->assertJsonStringEqualsJsonString(json_encode([
            'message' => 'Error en la solicitud AJAX',
            'response' => ResponseInterface::HTTP_CONFLICT,
            'data' => ''
        ]), $response);
    }
}
