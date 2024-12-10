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

    public function testSingleMenudiarioWithValidId()
    {
        // Simular que la solicitud es AJAX
        $this->request->setMethod('post');
        $this->controller->request = $this->request;

        // Simular que el modelo devuelve un solo menú diario
        $this->menuDiarioModelMock->method('where')->willReturnSelf();
        $this->menuDiarioModelMock->method('first')->willReturn([
            'idDiario' => 1, 'Dia' => 'Lunes', 'Descripcion' => 'Menú del día', 'Menu_id_fk' => 1
        ]);

        // Ejecutar el método singleMenudiario
        $response = $this->controller->singleMenudiario(1);

        // Verificar que la respuesta sea un JSON con los datos esperados
        $this->assertJsonStringEqualsJsonString(json_encode([
            'message' => 'success',
            'response' => ResponseInterface::HTTP_OK,
            'data' => ['idDiario' => 1, 'Dia' => 'Lunes', 'Descripcion' => 'Menú del día', 'Menu_id_fk' => 1],
            'csrf' => csrf_hash()
        ]), $response);
    }

    public function testSingleMenudiarioWithInvalidId()
    {
        // Simular que la solicitud es AJAX
        $this->request->setMethod('post');
        $this->controller->request = $this->request;

        // Simular que el modelo no devuelve nada
        $this->menuDiarioModelMock->method('where')->willReturnSelf();
        $this->menuDiarioModelMock->method('first')->willReturn(null);

        // Ejecutar el método singleMenudiario
        $response = $this->controller->singleMenudiario(999);

        // Verificar que la respuesta sea un error
        $this->assertJsonStringEqualsJsonString(json_encode([
            'message' => 'Error create user',
            'response' => ResponseInterface::HTTP_NO_CONTENT,
            'data' => ''
        ]), $response);
    }
}


