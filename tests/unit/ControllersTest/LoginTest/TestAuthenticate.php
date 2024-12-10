<?php

namespace App\Controllers;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Session\Session;

class LoginTest extends CIUnitTestCase
{
    protected $controller;
    protected $userModelMock;
    protected $sessionMock;

    protected function setUp(): void
    {
        parent::setUp();
        $this->controller = new Login();
        $this->userModelMock = $this->createMock(\App\Models\UsuarioModel::class);
        $this->sessionMock = $this->createMock(Session::class);

        // Inyectar el mock de la sesión
        $this->controller->session = $this->sessionMock;
        
        // Inyectar el mock del modelo
        $this->controller->usuarioModel = $this->userModelMock;
    }

    public function testAuthenticateSuccess()
    {
        // Simular que la solicitud POST contiene los datos correctos
        $this->request->setMethod('post')->setPost([
            'email' => 'test@example.com',
            'password' => 'correctpassword'
        ]);
        $this->controller->request = $this->request;

        // Simular que el modelo retorna un usuario válido
        $this->userModelMock->method('getUserWithRole')->willReturn([
            'idUsuario' => 1,
            'Email' => 'test@example.com',
            'Password' => password_hash('correctpassword', PASSWORD_DEFAULT),
            'Rol' => 'Admin'
        ]);

        // Ejecutar el método authenticate
        $response = $this->controller->authenticate();

        // Verificar que la sesión se ha establecido correctamente
        $this->assertTrue(session()->has('user_id'));
        $this->assertEquals('Admin', session()->get('role'));

        // Verificar que la respuesta es una redirección
        $this->assertRedirects($response, base_url('menu'));
    }

    public function testAuthenticateInvalidEmail()
    {
        // Simular que la solicitud POST contiene los datos incorrectos
        $this->request->setMethod('post')->setPost([
            'email' => 'nonexistent@example.com',
            'password' => 'password'
        ]);
        $this->controller->request = $this->request;

        // Simular que el modelo no encuentra el usuario
        $this->userModelMock->method('getUserWithRole')->willReturn(null);

        // Ejecutar el método authenticate
        $response = $this->controller->authenticate();

        // Verificar que la respuesta redirige con un mensaje de error
        $this->assertRedirects($response);
        $this->assertSessionHas('error');
    }

    public function testAuthenticateInvalidPassword()
    {
        // Simular que la solicitud POST contiene los datos incorrectos
        $this->request->setMethod('post')->setPost([
            'email' => 'test@example.com',
            'password' => 'wrongpassword'
        ]);
        $this->controller->request = $this->request;

        // Simular que el modelo encuentra el usuario pero la contraseña es incorrecta
        $this->userModelMock->method('getUserWithRole')->willReturn([
            'idUsuario' => 1,
            'Email' => 'test@example.com',
            'Password' => password_hash('correctpassword', PASSWORD_DEFAULT),
            'Rol' => 'Admin'
        ]);

        // Ejecutar el método authenticate
        $response = $this->controller->authenticate();

        // Verificar que la respuesta redirige con un mensaje de error
        $this->assertRedirects($response);
        $this->assertSessionHas('error');
    }

    public function testAuthenticateMissingFields()
    {
        // Simular que faltan campos (email o password) en la solicitud
        $this->request->setMethod('post')->setPost([
            'email' => ''
        ]);
        $this->controller->request = $this->request;

        // Ejecutar el método authenticate
        $response = $this->controller->authenticate();

        // Verificar que la respuesta redirige con un mensaje de error
        $this->assertRedirects($response);
        $this->assertSessionHas('error');
    }
}
