<?php

namespace App\Tests\Controllers;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Config\Services;
use App\Controllers\Usuario;

class UsuarioIndexTest extends CIUnitTestCase
{
    protected $usuarioController;

    protected function setUp(): void
    {
        parent::setUp();
        // Crear una instancia del controlador Usuario
        $this->usuarioController = new Usuario();
    }

    public function testIndexNoAutenticado()
    {
        // Simular sesión sin usuario autenticado
        $session = Services::session();
        $session->remove('user_id');
        
        $result = $this->usuarioController->index();
        
        // Verificar redirección a login
        $this->assertContains('login', $result->getBody());
    }

    public function testIndexAccesoDenegadoPorRol()
    {
        // Simular sesión con un usuario con rol incorrecto
        $session = Services::session();
        $session->set('user_id', 1);
        $session->set('role', 'Mesero');

        $result = $this->usuarioController->index();
        
        // Verificar que el acceso es denegado
        $this->assertContains('login', $result->getBody());
    }

    public function testIndexConExito()
    {
        // Simular sesión con usuario Admin
        $session = Services::session();
        $session->set('user_id', 1);
        $session->set('role', 'Admin');

        $result = $this->usuarioController->index();
        
        // Verificar que la vista se carga correctamente
        $this->assertContains('USUARIOS', $result->getBody());
    }
}
