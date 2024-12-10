<?php

namespace App\Tests;

use App\Controllers\Role;
use App\Models\RolesModel;
use CodeIgniter\Test\ControllerTestCase;
use CodeIgniter\Config\Services;

class TestUpdate extends ControllerTestCase
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

    public function testUpdateAjaxRequest()
    {
        $this->withBody([
            'idRoles' => 1,
            'Rol' => 'Admin',
            'Descripcion' => 'Updated Admin Role'
        ]);

        $this->roleModel->expects($this->once())
            ->method('update')
            ->with(1, [
                'Rol' => 'Admin',
                'Descripcion' => 'Updated Admin Role',
                'update_at' => date("Y-m-d H:i:s"),
            ])
            ->willReturn(true);

        $response = $this->withRequest()->controller(Role::class)->update();
        $response->assertJSON(['message' => 'success', 'response' => 200]);
    }

    public function testUpdateNonAjaxRequest()
    {
        $response = $this->withRequest()->controller(Role::class)->update();
        $response->assertJSON(['message' => 'Error Ajax', 'response' => 409]);
    }
}
