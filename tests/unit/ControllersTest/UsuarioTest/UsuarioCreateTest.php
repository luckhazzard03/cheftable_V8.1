<?php

namespace App\Tests\Controllers;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Config\Services;
use App\Controllers\Usuario;

class UsuarioCreateTest extends CIUnitTestCase
{
    protected $usuarioController;

    protected function setUp(): void
    {
        parent::setUp();
        $this->usuarioController = new Usuario();
    }

    public function testCreateUsuarioExitoso()
    {
        // Simular una solicitud AJAX
        $this->request->setMethod('ajax');
        $this->request->setPost([
            'idUsuario' => 1,
            'Nombre' => 'Juan',
            'Password' => 'password123',
            'Email' => 'juan@correo.com',
            'Telefono' => '123456789',
            'idRoles_fk' => 1,
            'create_at' => '2024-11-26 12:00:00',
            'update_at' => '2024-11-26 12:00:00'
        ]);

        $result = $this->usuarioController->create();
        
        // Verificar que la respuesta es un JSON con mensaje de éxito
        $this->assertJson($result);
        $data = json_decode($result, true);
        $this->assertEquals('success', $data['message']);
    }

    public function testCreateUsuarioError()
    {
        // Simular una solicitud AJAX sin datos correctos
        $this->request->setMethod('ajax');
        $this->request->setPost([]);

        $result = $this->usuarioController->create();
        
        // Verificar que la respuesta es un JSON con mensaje de error
        $this->assertJson($result);
        $data = json_decode($result, true);
        $this->assertEquals('Error creating user', $data['message']);
    }
}
