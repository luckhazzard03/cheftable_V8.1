<?php

namespace App\Controllers;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\HTTP\ResponseInterface;

class ComandaTest extends CIUnitTestCase
{
    protected $controller;
    protected $comandaModelMock;

    protected function setUp(): void
    {
        parent::setUp();
        $this->controller = new Comanda();
        $this->comandaModelMock = $this->createMock(\App\Models\ComandaModel::class);
        $this->controller->comandaModel = $this->comandaModelMock;
    }

    public function testDeleteComandaSuccess()
    {
        // Simular que el modelo delete retorna true
        $this->comandaModelMock->method('where')->willReturnSelf();
        $this->comandaModelMock->method('delete')->willReturn(true);

        // Ejecutar el método delete
        $response = $this->controller->delete(1);

        // Verificar que la respuesta es un JSON con mensaje de éxito
        $data = json_decode($response->getBody(), true);
        $this->assertEquals('success', $data['message']);
        $this->assertEquals(ResponseInterface::HTTP_OK, $data['response']);
    }

    public function testDeleteComandaFailure()
    {
        // Simular que el modelo delete retorna false
        $this->comandaModelMock->method('where')->willReturnSelf();
        $this->comandaModelMock->method('delete')->willReturn(false);

        // Ejecutar el método delete
        $response = $this->controller->delete(1);

        // Verificar que la respuesta es un JSON con mensaje de error
        $data = json_decode($response->getBody(), true);
        $this->assertEquals('Error create user', $data['message']);
        $this->assertEquals(ResponseInterface::HTTP_NO_CONTENT, $data['response']);
    }

    public function testDeleteComandaException()
    {
        // Simular una excepción en el modelo delete
        $this->comandaModelMock->method('where')->willReturnSelf();
        $this->comandaModelMock->method('delete')->will($this->throwException(new \Exception('Error en la eliminación')));

        // Ejecutar el método delete
        $response = $this->controller->delete(1);

        // Verificar que la respuesta contiene el error de excepción
        $data = json_decode($response->getBody(), true);
        $this->assertEquals('Error en la eliminación', $data['message']);
        $this->assertEquals(ResponseInterface::HTTP_CONFLICT, $data['response']);
    }
}

