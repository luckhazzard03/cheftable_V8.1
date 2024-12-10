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

    public function testUpdateWithValidRequest()
    {
        $postData = [
            'idProveedor' => 1,
            'Nombre' => 'Proveedor Actualizado',
            'Direccion' => 'Nueva Direccion',
            'Telefono' => '987654321',
            'Tipo' => 'Proveedor',
            'idUsuario_fk' => 2,
            'create_at' => '2024-01-01 12:00:00',
            'update_at' => '2024-01-02 12:00:00'
        ];

        // Simular la solicitud AJAX
        $this->request->setMethod('post')->setPost($postData);
        $this->controller->request = $this->request;

        // Simular que el modelo actualiza correctamente el proveedor
        $this->proveedorModelMock->method('update')->willReturn(true);

        // Ejecutar el método update()
        $response = $this->controller->update();

        // Verificar que la respuesta sea la esperada
        $this->assertJsonStringEqualsJsonString(json_encode([
            'message' => 'success',
            'response' => ResponseInterface::HTTP_OK,
            'data' => $postData,
            'csrf' => csrf_hash()
        ]), $response);
    }

    public function testUpdateWithInvalidRequest()
    {
        // Simular que no se realiza una solicitud AJAX
        $this->request->setMethod('post');
        $this->controller->request = $this->request;

        // Ejecutar el método update()
        $response = $this->controller->update();

        // Verificar que la respuesta sea de error por solicitud no válida
        $this->assertJsonStringEqualsJsonString(json_encode([
            'message' => 'Error en la solicitud AJAX',
            'response' => ResponseInterface::HTTP_CONFLICT,
            'data' => ''
        ]), $response);
    }

    public function testUpdateWithFailedModel()
    {
        $postData = [
            'idProveedor' => 1,
            'Nombre' => 'Proveedor Actualizado',
            'Direccion' => 'Nueva Direccion',
            'Telefono' => '987654321',
            'Tipo' => 'Proveedor',
            'idUsuario_fk' => 2,
            'create_at' => '2024-01-01 12:00:00',
            'update_at' => '2024-01-02 12:00:00'
        ];

        // Simular la solicitud AJAX
        $this->request->setMethod('post')->setPost($postData);
        $this->controller->request = $this->request;

        // Simular que el modelo no logra actualizar el proveedor
        $this->proveedorModelMock->method('update')->willReturn(false);

        // Ejecutar el método update()
        $response = $this->controller->update();

        // Verificar que la respuesta de error se devuelva
        $this->assertJsonStringEqualsJsonString(json_encode([
            'message' => 'Error al actualizar el proveedor',
            'response' => ResponseInterface::HTTP_NO_CONTENT,
            'data' => ''
        ]), $response);
    }
}