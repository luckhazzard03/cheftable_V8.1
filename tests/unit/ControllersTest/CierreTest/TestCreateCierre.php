<?php

namespace App\Tests;

use App\Controllers\Role;
use App\Models\RolesModel;
use CodeIgniter\Test\ControllerTestCase;
use CodeIgniter\Config\Services;

class TestCreate extends ControllerTestCase
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

    public function testCreateAjaxRequest()
    {
        $this->withBody([
            'idRoles' => 1,
            'Rol' => 'Admin',
            'Descripcion' => 'Administrator role'
        ]);

        $this->roleModel->expects($this->once())
            ->method('insert')
            ->with([
                'idRoles' => 1,
                'Rol' => 'Admin',
                'Descripcion' => 'Administrator role',
                'create_at' => date("Y-m-d H:i:s"),
                'update_at' => date("Y-m-d H:i:s"),
            ])
            ->willReturn(true);

        $response = $this->withRequest()->controller(Role::class)->create();
        $response->assertJSON(['message' => 'success', 'response' => 200]);
    }

    public function testCreateNonAjaxRequest()
    {
        $response = $this->withRequest()->controller(Role::class)->create();
        $response->assertJSON(['message' => 'Error Ajax', 'response' => 409]);
    }
}
