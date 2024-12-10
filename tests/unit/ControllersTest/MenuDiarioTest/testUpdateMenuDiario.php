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

    public function testUpdateWithValidRequest()
    {
        // Simular que la solicitud es AJAX
        $this->request->setMethod('post')->setPost([
            'idDiario' => 1,
            'Dia' => 'Martes',
            'Descripcion' => 'Menú actualizado',
            'Menu_id_fk' => 1,
            'create_at' => '2024-01-01 12:00:00',
            'update_at' => '2024-01-02 12:00:00'
        ]);
        $this->controller->request = $this->request;

        // Simular que el modelo actualiza correctamente
        $this->menuDiarioModelMock->method('update')->willReturn(true);

        // Ejecutar el método update
        $response = $this->controller->update();

        // Verificar que la respuesta sea un JSON con 'success'
        $this->assertJsonStringEqualsJsonString(json_encode([
            'message' => 'success',
            'response' => ResponseInterface::HTTP_OK,
            'data' => [
                'idDiario' => 1,
                'Dia' => 'Martes',
                'Descripcion' => 'Menú actualizado',
                'Menu_id_fk' => 1,
                'create_at' => '2024-01-01 12:00:00',
                'update_at' => '2024-01-02 12:00:00'
            ],
            'csrf' => csrf_hash()
        ]), $response);
    }

    public function testUpdateWithInvalidRequest()
    {
        // Simular que no es una solicitud AJAX
        $this->request->setMethod('post');
        $this->controller->request = $this->request;

        // Ejecutar el método update
        $response = $this->controller->update();

        // Verificar que la respuesta sea un error
        $this->assertJsonStringEqualsJsonString(json_encode([
            'message' => 'Error Ajax',
            'response' => ResponseInterface::HTTP_CONFLICT,
            'data' => ''
        ]), $response);
    }
}


