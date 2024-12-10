<?php

namespace App\Tests;

use App\Controllers\Role;
use App\Models\RolesModel;
use CodeIgniter\Test\ControllerTestCase;
use CodeIgniter\Config\Services;

class TestIndex extends ControllerTestCase
{
    protected $roleModel;
    protected $controller;

    protected function setUp(): void
    {
        parent::setUp();
        $this->roleModel = $this->createMock(RolesModel::class);
        $this->controller = new Role();
        $this->controller->roleModel = $this->roleModel;
    }

    public function testIndexUnauthenticated()
    {
        session()->remove('user_id');
        $response = $this->withRequest()->controller(Role::class)->index();
        $response->assertRedirect('/login');
    }

    public function testIndexUnauthorized()
    {
        session()->set('user_id', 1);
        session()->set('role', 'User');
        $response = $this->withRequest()->controller(Role::class)->index();
        $response->assertRedirect('/login');
    }

    public function testIndexAuthorized()
    {
        session()->set('user_id', 1);
        session()->set('role', 'Admin');

        $this->roleModel->expects($this->once())
            ->method('orderBy')
            ->with('idRoles', 'ASC')
            ->willReturnSelf();

        $this->roleModel->expects($this->once())
            ->method('findAll')
            ->willReturn([
                ['idRoles' => 1, 'Rol' => 'Admin', 'Descripcion' => 'Administrator role'],
                ['idRoles' => 2, 'Rol' => 'User', 'Descripcion' => 'Regular user'],
            ]);

        $response = $this->withRequest()->controller(Role::class)->index();
        $response->assertViewIs('role/role_view');
    }
}
