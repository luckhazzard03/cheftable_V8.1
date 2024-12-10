<?php

namespace App\Controllers;

use App\Models\ProveedorModel;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\ResponseInterface;

class Proveedor extends Controller
{
    private $primaryKey;
    private $proveedorModel;
    private $data;
    private $model;

    // Constructor
    public function __construct()
    {
        $this->primaryKey = "idProveedor";
        $this->proveedorModel = new ProveedorModel();
        $this->data = [];
        $this->model = "proveedor";
    }

    // Método index para mostrar los proveedores
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
        log_message('debug', 'Rol del usuario desde la sesión: ' . json_encode($userRole));

        // Verificar si el rol del usuario es uno de los roles permitidos ('Admin', 'Chef', 'Mesero')
        if (!in_array($userRole, ['Admin', 'Chef', 'Mesero'])) {
            log_message('error', 'Acceso denegado: el usuario no tiene un rol permitido. Rol encontrado: ' . json_encode($userRole));
            return redirect()->to('/login');
        }

        // Si el rol es adecuado, cargar la vista de proveedores
        $this->data['title'] = "PROVEEDOR";
        $this->data[$this->model] = $this->proveedorModel->orderBy($this->primaryKey, 'ASC')->findAll();
         // Mapeo de roles
		 $roles = [
			1 => 'ADMIN',
			2 => 'CHEF'
		];
	
		// Reemplazar idUsuario_fk con el nombre del rol
		foreach ($this->data[$this->model] as &$obj) {
			$obj['Rol'] = isset($roles[$obj['idUsuario_fk']]) ? $roles[$obj['idUsuario_fk']] : 'Desconocido';
		}
        return view('proveedor/proveedor_view', $this->data);
    }

    // Método para crear un nuevo proveedor
    public function create()
    {
        if ($this->request->isAJAX()) {
            $dataModel = $this->getDataModel();
            if ($this->proveedorModel->insert($dataModel)) {
                $data['message'] = 'success';
                $data['response'] = ResponseInterface::HTTP_OK;
                $data['data'] = $dataModel;
                $data['csrf'] = csrf_hash();
            } else {
                $data['message'] = 'Error al crear el proveedor';
                $data['response'] = ResponseInterface::HTTP_NO_CONTENT;
                $data['data'] = '';
            }
        } else {
            $data['message'] = 'Error en la solicitud AJAX';
            $data['response'] = ResponseInterface::HTTP_CONFLICT;
            $data['data'] = '';
        }
        echo json_encode($data);
    }

    // Método para obtener los datos del modelo
    public function getDataModel()
    {
        $data = [
            'idProveedor' => $this->request->getVar('idProveedor'),
            'Nombre' => $this->request->getVar('Nombre'),
            'Direccion' => $this->request->getVar('Direccion'),
            'Telefono' => $this->request->getVar('Telefono'),
            'Tipo' => $this->request->getVar('Tipo'),
            'idUsuario_fk' => $this->request->getVar('idUsuario_fk'),
            'create_at' => $this->request->getVar('create_at'),
            'update_at' => $this->request->getVar('update_at'),
        ];
        return $data;
    }

    // Método para obtener un solo proveedor
    public function singleProveedor($id = null)
    {
        if ($this->request->isAJAX()) {
            if ($data[$this->model] = $this->proveedorModel->where($this->primaryKey, $id)->first()) {
                $data['message'] = 'success';
                $data['response'] = ResponseInterface::HTTP_OK;
                $data['csrf'] = csrf_hash();
            } else {
                $data['message'] = 'Proveedor no encontrado';
                $data['response'] = ResponseInterface::HTTP_NO_CONTENT;
                $data['data'] = '';
            }
        } else {
            $data['message'] = 'Error en la solicitud AJAX';
            $data['response'] = ResponseInterface::HTTP_CONFLICT;
            $data['data'] = '';
        }
        echo json_encode($data);
    }

    // Método para actualizar un proveedor
    public function update()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar($this->primaryKey);
            $dataModel = [
                'Nombre' => $this->request->getVar('Nombre'),
                'Direccion' => $this->request->getVar('Direccion'),
                'Telefono' => $this->request->getVar('Telefono'),
                'Tipo' => $this->request->getVar('Tipo'),
                'idUsuario_fk' => $this->request->getVar('idUsuario_fk'),
                'create_at' => $this->request->getVar('create_at'),
                'update_at' => $this->request->getVar('update_at'),
            ];
            if ($this->proveedorModel->update($id, $dataModel)) {
                $data['message'] = 'success';
                $data['response'] = ResponseInterface::HTTP_OK;
                $data['data'] = $dataModel;
                $data['csrf'] = csrf_hash();
            } else {
                $data['message'] = 'Error al actualizar el proveedor';
                $data['response'] = ResponseInterface::HTTP_NO_CONTENT;
                $data['data'] = '';
            }
        } else {
            $data['message'] = 'Error en la solicitud AJAX';
            $data['response'] = ResponseInterface::HTTP_CONFLICT;
            $data['data'] = '';
        }
        echo json_encode($data);
    }

    // Método para eliminar un proveedor
    public function delete($id = null)
    {
        try {
            if ($this->proveedorModel->where($this->primaryKey, $id)->delete($id)) {
                $data['message'] = 'success';
                $data['response'] = ResponseInterface::HTTP_OK;
                $data['data'] = "OK";
                $data['csrf'] = csrf_hash();
            } else {
                $data['message'] = 'Error al eliminar el proveedor';
                $data['response'] = ResponseInterface::HTTP_NO_CONTENT;
                $data['data'] = '';
            }
        } catch (\Exception $e) {
            $data['message'] = $e;
            $data['response'] = ResponseInterface::HTTP_CONFLICT;
            $data['data'] = '';
        }
        echo json_encode($data);
    }
}
