<?php

namespace App\Tests;

use App\Controllers\Role;
use App\Models\RolesModel;
use CodeIgniter\Test\ControllerTestCase;
use CodeIgniter\Config\Services;

class TestDelete extends ControllerTestCase
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

    public function testDeleteRoleSuccess()
    {
        $this->roleModel->expects($this->once())
            ->method('where')
            ->with('idRoles', 1)
            ->willReturnSelf();

        $this->roleModel->expects($this->once())
            ->method('delete')
            ->with(1)
            ->willReturn(true);

        $response = $this->withRequest()->controller(Role::class)->delete(1);
        $response->assertJSON(['message' => 'success', 'response' => 200]);
    }

    public function testDeleteRoleError()
    {
        $this->roleModel->expects($this->once())
            ->method('where')
            ->with('idRoles', 1)
            ->willReturnSelf();

        $this->roleModel->expects($this->once())
            ->method('delete')
            ->with(1)
            ->willReturn(false);

        $response = $this->withRequest()->controller(Role::class)->delete(1);
        $response->assertJSON(['message' => 'Error deleting role', 'response' => 204]);
    }
}

