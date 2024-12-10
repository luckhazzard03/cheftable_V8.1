<?php

namespace App\Tests\Controllers;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Config\Services;
use App\Controllers\Usuario;
use CodeIgniter\HTTP\ResponseInterface;

class UsuarioDeleteTest extends CIUnitTestCase
{
    protected $usuarioController;

    protected function setUp(): void
    {
        parent::setUp();
        $this->usuarioController = new Usuario();
    }

    public function testDeleteUsuarioExitoso()
    {
        // Simular una solicitud AJAX
        $this->request->setMethod('ajax');
        $this->request->setGet('id', 1);  // Supongamos que el usuario con id 1 existe

        // Simular que el usuario fue eliminado correctamente
        $this->usuarioController->usuarioModel = $this->createMock(\App\Models\UsuarioModel::class);
        $this->usuarioController->usuarioModel->method('delete')->willReturn(true);

        $result = $this->usuarioController->delete(1);

        // Verificar que la respuesta sea un JSON con mensaje de éxito
        $this->assertJson($result);
        $data = json_decode($result, true);
        $this->assertEquals('success', $data['message']);
        $this->assertEquals(ResponseInterface::HTTP_OK, $data['response']);
    }

    public function testDeleteUsuarioErrorSinAJAX()
    {
        // Simular que la solicitud no es AJAX
        $this->request->setMethod('get');
        $this->request->setGet('id', 1);  // ID de usuario

        $result = $this->usuarioController->delete(1);
        
        // Verificar que la respuesta es un error porque no es AJAX
        $this->assertJson($result);
        $data = json_decode($result, true);
        $this->assertEquals('Error Ajax', $data['message']);
        $this->assertEquals(ResponseInterface::HTTP_CONFLICT, $data['response']);
    }

    public function testDeleteUsuarioNoExitoso()
    {
        // Simular una solicitud AJAX
        $this->request->setMethod('ajax');
        $this->request->setGet('id', 1);  // Supongamos que el usuario con id 1 existe

        // Simular que el método `delete()` de `UsuarioModel` falla
        $this->usuarioController->usuarioModel = $this->createMock(\App\Models\UsuarioModel::class);
        $this->usuarioController->usuarioModel->method('delete')->willReturn(false);

        $result = $this->usuarioController->delete(1);

        // Verificar que la respuesta es un JSON con mensaje de error
        $this->assertJson($result);
        $data = json_decode($result, true);
        $this->assertEquals('Error deleting user', $data['message']);
        $this->assertEquals(ResponseInterface::HTTP_NO_CONTENT, $data['response']);
    }

    public function testDeleteUsuarioException()
    {
        // Simular una solicitud AJAX
        $this->request->setMethod('ajax');
        $this->request->setGet('id', 1);  // Supongamos que el usuario con id 1 existe

        // Simular que el método `delete()` de `UsuarioModel` lanza una excepción
        $this->usuarioController->usuarioModel = $this->createMock(\App\Models\UsuarioModel::class);
        $this->usuarioController->usuarioModel->method('delete')->will($this->throwException(new \Exception("Database error")));

        $result = $this->usuarioController->delete(1);

        // Verificar que la respuesta contiene el mensaje de excepción
        $this->assertJson($result);
        $data = json_decode($result, true);
        $this->assertStringContainsString('Exception', $data['message']);
        $this->assertEquals(ResponseInterface::HTTP_CONFLICT, $data['response']);
    }
}
