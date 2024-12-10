<?php

namespace App\Tests\Controllers;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Config\Services;
use App\Controllers\Usuario;
use CodeIgniter\HTTP\ResponseInterface;

class UsuarioUpdateTest extends CIUnitTestCase
{
    protected $usuarioController;

    protected function setUp(): void
    {
        parent::setUp();
        $this->usuarioController = new Usuario();
    }

    public function testUpdateUsuarioExitoso()
    {
        // Simular una solicitud AJAX
        $this->request->setMethod('ajax');
        $this->request->setPost([
            'idUsuario' => 1,  // Supongamos que este ID existe en la base de datos
            'Nombre' => 'Juan Actualizado',
            'Password' => 'newpassword123',
            'Email' => 'juan@correo.com',
            'Telefono' => '987654321',
            'idRoles_fk' => 1,
            'update_at' => '2024-11-26 15:00:00'
        ]);

        // Simular que el usuario existe y actualizar
        $this->usuarioController->usuarioModel = $this->createMock(\App\Models\UsuarioModel::class);
        $this->usuarioController->usuarioModel->method('update')->willReturn(true);

        $result = $this->usuarioController->update();

        // Verificar que la respuesta sea un JSON con mensaje de éxito
        $this->assertJson($result);
        $data = json_decode($result, true);
        $this->assertEquals('success', $data['message']);
        $this->assertEquals(ResponseInterface::HTTP_OK, $data['response']);
    }

    public function testUpdateUsuarioErrorSinAJAX()
    {
        // Simular que la solicitud no es AJAX
        $this->request->setMethod('post');
        $this->request->setPost([
            'idUsuario' => 1,
            'Nombre' => 'Juan Actualizado',
            'Password' => 'newpassword123',
            'Email' => 'juan@correo.com',
            'Telefono' => '987654321',
            'idRoles_fk' => 1,
            'update_at' => '2024-11-26 15:00:00'
        ]);

        $result = $this->usuarioController->update();
        
        // Verificar que la respuesta es un error porque no es AJAX
        $this->assertJson($result);
        $data = json_decode($result, true);
        $this->assertEquals('Error Ajax', $data['message']);
        $this->assertEquals(ResponseInterface::HTTP_CONFLICT, $data['response']);
    }

    public function testUpdateUsuarioNoExitoso()
    {
        // Simular una solicitud AJAX
        $this->request->setMethod('ajax');
        $this->request->setPost([
            'idUsuario' => 1,  // Supongamos que este ID existe en la base de datos
            'Nombre' => 'Juan Actualizado',
            'Password' => 'newpassword123',
            'Email' => 'juan@correo.com',
            'Telefono' => '987654321',
            'idRoles_fk' => 1,
            'update_at' => '2024-11-26 15:00:00'
        ]);

        // Simular que el método `update()` de `UsuarioModel` falla
        $this->usuarioController->usuarioModel = $this->createMock(\App\Models\UsuarioModel::class);
        $this->usuarioController->usuarioModel->method('update')->willReturn(false);

        $result = $this->usuarioController->update();

        // Verificar que la respuesta es un JSON con mensaje de error
        $this->assertJson($result);
        $data = json_decode($result, true);
        $this->assertEquals('Error updating user', $data['message']);
        $this->assertEquals(ResponseInterface::HTTP_NO_CONTENT, $data['response']);
    }
}


