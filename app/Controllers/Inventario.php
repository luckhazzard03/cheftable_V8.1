<?php

namespace App\Controllers;

use App\Models\InventarioModel;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\ResponseInterface;

class Inventario extends Controller
{
    private $primaryKey;
    private $inventarioModel;
    private $data;
    private $model;

    public function __construct()
    {
        $this->primaryKey = "idInventario";
        $this->inventarioModel = new InventarioModel();
        $this->data = [];
        $this->model = "inventario";
    }

    public function index()
    {
        // Verificar si la sesión está activa
        $session = session();
        if (!$session->has('user_id')) {
            log_message('error', 'Usuario no autenticado.');
            return redirect()->to('/login');
        }
    
        // Verificar el rol del usuario
        $userRole = $session->get('role');
        if (!in_array($userRole, ['Admin', 'Chef'])) {
            log_message('error', 'Acceso denegado: el usuario no tiene un rol permitido.');
            return redirect()->to('/login');
        }
    
        // Cargar la vista de inventario si tiene permisos
        $this->data['title'] = "INVENTARIO";
        $this->data[$this->model] = $this->inventarioModel->orderBy($this->primaryKey, 'ASC')->findAll();
        // Mapeo de roles
		$roles = [
			1 => 'ADMIN',
			2 => 'CHEF',
	
		];
	
		// Reemplazar idUsuario_fk con el nombre del rol
		foreach ($this->data[$this->model] as &$obj) {
			$obj['Rol'] = isset($roles[$obj['idUsuario_fk']]) ? $roles[$obj['idUsuario_fk']] : 'Desconocido';
		}
        return view('inventario/inventario_view', $this->data);
    }
    public function create()
    {
        if ($this->request->isAJAX()) {
            $dataModel = $this->getDataModel();
            if ($this->inventarioModel->insert($dataModel)) {
                $data['message'] = 'success';
                $data['response'] = ResponseInterface::HTTP_OK;
                $data['data'] = $dataModel;
                $data['csrf'] = csrf_hash();
            } else {
                $data['message'] = 'Error al crear el inventario';
                $data['response'] = ResponseInterface::HTTP_NO_CONTENT;
                $data['data'] = '';
            }
            return $this->response->setJSON($data);
        }
    }

    public function singleInventario($id = null)
    {
        if ($this->request->isAJAX()) {
            if ($data[$this->model] = $this->inventarioModel->where($this->primaryKey, $id)->first()) {
                $data['message'] = 'success';
                $data['response'] = ResponseInterface::HTTP_OK;
                $data['csrf'] = csrf_hash();
            } else {
                $data['message'] = 'Error al obtener el inventario';
                $data['response'] = ResponseInterface::HTTP_NO_CONTENT;
                $data['data'] = '';
            }
            return $this->response->setJSON($data);
        }
    }

    public function update()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar($this->primaryKey);
            $dataModel = [
                'Producto' => $this->request->getVar('Producto'),
                'Cantidad' => $this->request->getVar('Cantidad'),
                'Cantidad_Minima' => $this->request->getVar('Cantidad_Minima'),
                'idUsuario_fk' => $this->request->getVar('idUsuario_fk'),
                'create_at' => $this->request->getVar('create_at'),
                'update_at' => date("Y-m-d H:i:s"),
            ];

            if ($this->inventarioModel->update($id, $dataModel)) {
                $data['message'] = 'success';
                $data['response'] = ResponseInterface::HTTP_OK;
                $data['data'] = $dataModel;
                $data['csrf'] = csrf_hash();
            } else {
                $data['message'] = 'Error al actualizar el inventario';
                $data['response'] = ResponseInterface::HTTP_NO_CONTENT;
                $data['data'] = '';
            }
            return $this->response->setJSON($data);
        }
    }

    public function delete($id = null)
    {
        try {
            if ($this->inventarioModel->where($this->primaryKey, $id)->delete($id)) {
                $data['message'] = 'success';
                $data['response'] = ResponseInterface::HTTP_OK;
                $data['data'] = "OK";
                $data['csrf'] = csrf_hash();
            } else {
                $data['message'] = 'Error al eliminar el inventario';
                $data['response'] = ResponseInterface::HTTP_NO_CONTENT;
                $data['data'] = '';
            }
        } catch (\Exception $e) {
            $data['message'] = $e->getMessage();
            $data['response'] = ResponseInterface::HTTP_CONFLICT;
            $data['data'] = '';
        }
        return $this->response->setJSON($data);
    }

    public function getDataModel()
    {
        $data = [
            'idInventario' => $this->request->getVar('idInventario'),
            'Producto' => $this->request->getVar('Producto'),
            'Cantidad' => $this->request->getVar('Cantidad'),
            'Cantidad_Minima' => $this->request->getVar('Cantidad_Minima'),
            'idUsuario_fk' => $this->request->getVar('idUsuario_fk'),
            'create_at' => $this->request->getVar('create_at'),
            'update_at' => $this->request->getVar('update_at'),
        ];
        return $data;
    }
}
