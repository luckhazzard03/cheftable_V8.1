<?php

namespace App\Tests\Controllers;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Config\Services;
use App\Controllers\Usuario;

class UsuarioSingleUsuarioTest extends CIUnitTestCase
{
    protected $usuarioController;

    protected function setUp(): void
    {
        parent::setUp();
        $this->usuarioController = new Usuario();
    }

    public function testSingleUsuarioExitoso()
    {
        // Simular una solicitud AJAX
        $this->request->setMethod('ajax');
        $this->request->setGet('id', 1);

        $result = $this->usuarioController->singleUsuario(1);
        
        // Verificar que la respuesta contiene el mensaje de éxito
        $this->assertJson($result);
        $data = json_decode($result, true);
        $this->assertEquals('success', $data['message']);
    }

    public function testSingleUsuarioNoEncontrado()
    {
        // Simular una solicitud AJAX para un usuario que no existe
        $this->request->setMethod('ajax');
        $this->request->setGet('id', 9999);

        $result = $this->usuarioController->singleUsuario(9999);
        
        // Verificar que la respuesta contiene el mensaje de error
        $this->assertJson($result);
        $data = json_decode($result, true);
        $this->assertEquals('User not found', $data['message']);
    }
}
