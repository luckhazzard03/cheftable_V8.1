<?php

namespace App\Tests;

use App\Controllers\Role;
use App\Models\RolesModel;
use CodeIgniter\Test\ControllerTestCase;
use CodeIgniter\Config\Services;

class TestSingleRole extends ControllerTestCase
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

    public function testSingleRoleAjaxRequestFound()
    {
        $this->withRequest()->setMethod('POST');
        
        $this->roleModel->expects($this->once())
            ->method('where')
            ->with('idRoles', 1)
            ->willReturnSelf();
        
        $this->roleModel->expects($this->once())
            ->method('first')
            ->willReturn(['idRoles' => 1, 'Rol' => 'Admin']);

        $response = $this->withRequest()->controller(Role::class)->singleRole(1);
        $response->assertJSON(['message' => 'success', 'response' => 200]);
    }

    public function testSingleRoleAjaxRequestNotFound()
    {
        $this->withRequest()->setMethod('POST');

        $this->roleModel->expects($this->once())
            ->method('where')
            ->with('idRoles', 999)
            ->willReturnSelf();
        
        $this->roleModel->expects($this->once())
            ->method('first')
            ->willReturn(null);

        $response = $this->withRequest()->controller(Role::class)->singleRole(999);
        $response->assertJSON(['message' => 'Error retrieving role', 'response' => 204]);
    }
}
