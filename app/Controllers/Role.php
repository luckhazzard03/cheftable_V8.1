<?php

namespace App\Controllers;

use App\Models\RolesModel;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\ResponseInterface;

class Role extends Controller
{
    private $primaryKey;
    private $roleModel;
    private $data;
    private $model;

    // Constructor
    public function __construct()
    {
        // Inicialización de variables
        $this->primaryKey = "idRoles";
        $this->roleModel = new RolesModel();
        $this->data = [];
        $this->model = "roles";
    }

    // Método index para mostrar los roles
    public function index()
    {
        // Verificar si la sesión está activa
        $session = session();
        if (!$session->has('user_id')) {
            log_message('error', 'Usuario no autenticado.');
            return redirect()->to('/login');
        }

        // Verificar si el usuario tiene un rol guardado en la sesión
        $userRole = $session->get('role');
        log_message('debug', 'Rol del usuario desde la sesión: ' . json_encode($userRole)); // Depurar valor de role

        // Si el rol no está en la sesión o no tiene permisos, denegar acceso
        if ($userRole !== 'Admin') {
            log_message('error', 'Acceso denegado: el usuario no tiene rol de admin. Rol encontrado: ' . json_encode($userRole)); // Depurar acceso denegado
            return redirect()->to('/login');
        }

        // Si la sesión es válida y tiene el rol adecuado, cargar la vista de roles
        $this->data['title'] = "ROLES";
        $this->data[$this->model] = $this->roleModel->orderBy($this->primaryKey, 'ASC')->findAll();
        $roles = [
            1 => 'ADMIN',
            2 => 'CHEF',
            3 => 'MESERO',
            4 => 'MESERO2',
            5 => 'MESERO3',
            6 => 'MESERO4',
            7 => 'MESERO5',
            8 => 'MESERO6',

        ];

        // Reemplazar idRoles_fk con el nombre del rol
        foreach ($this->data[$this->model] as &$obj) {
            $obj['Rol'] = isset($roles[$obj['idRoles']]) ? $roles[$obj['idRoles']] : 'Desconocido';
        }
        return view('role/role_view', $this->data);
    }

    // Método para crear un nuevo rol
    public function create()
    {
        if ($this->request->isAJAX()) {
            $dataModel = $this->getDataModel();
            // Encriptar la contraseña antes de insertar en la base de datos
            //$hashedPassword = password_hash($dataModel['Password'], PASSWORD_DEFAULT);
            //$dataModel['Password'] = substr($hashedPassword, 0, 15); // Truncar a 7 caracteres
            // Query Insert CodeIgniter
            if ($this->roleModel->insert($dataModel)) {
                $data['message'] = 'success';
                $data['response'] = ResponseInterface::HTTP_OK;
                $data['data'] = $dataModel;
                $data['csrf'] = csrf_hash();
            } else {
                $data['message'] = 'Error creating role';
                $data['response'] = ResponseInterface::HTTP_NO_CONTENT;
                $data['data'] = '';
            }
        } else {
            $data['message'] = 'Error Ajax';
            $data['response'] = ResponseInterface::HTTP_CONFLICT;
            $data['data'] = '';
        }
        //Change array to Json 
        echo json_encode($dataModel);
    }

    // Método para obtener un rol específico
    public function singleRole($id = null)
    {
        if ($this->request->isAJAX()) {
            if ($data[$this->model] = $this->roleModel->where($this->primaryKey, $id)->first()) {
                $data['message'] = 'success';
                $data['response'] = ResponseInterface::HTTP_OK;
                $data['csrf'] = csrf_hash();
            } else {
                $data['message'] = 'Error retrieving role';
                $data['response'] = ResponseInterface::HTTP_NO_CONTENT;
                $data['data'] = '';
            }
        } else {
            $data['message'] = 'Error Ajax';
            $data['response'] = ResponseInterface::HTTP_CONFLICT;
            $data['data'] = '';
        }
        //Change array to Json 
        echo json_encode($data);
    }

    // Método para actualizar un rol existente
    public function update()
    {
        if ($this->request->isAJAX()) {
            //$today = date("Y-m-d  H:i:s");
            $id = $this->request->getVar($this->primaryKey);
            $dataModel = [
                'idRoles' => $this->request->getVar('Rol'),
                'Descripcion' => $this->request->getVar('Descripcion'),
                'update_at' => $this->request->getVar('update_at'),

            ];

            if ($this->roleModel->update($id, $dataModel)) {
                $data['message'] = 'success';
                $data['response'] = ResponseInterface::HTTP_OK;
                $data['data'] = $dataModel;
                $data['csrf'] = csrf_hash();
            } else {
                $data['message'] = 'Error updating role';
                $data['response'] = ResponseInterface::HTTP_NO_CONTENT;
                $data['data'] = '';
            }
        } else {
            $data['message'] = 'Error Ajax';
            $data['response'] = ResponseInterface::HTTP_CONFLICT;
            $data['data'] = '';
        }
        // Change array to Json
        echo json_encode($data);
    }

    // Método para eliminar un rol
    public function delete($id = null)
    {
        try {
            if ($this->roleModel->where($this->primaryKey, $id)->delete($id)) {
                $data['message'] = 'success';
                $data['response'] = ResponseInterface::HTTP_OK;
                $data['data'] = "OK";
                $data['csrf'] = csrf_hash();
            } else {
                $data['message'] = 'Error deleting role';
                $data['response'] = ResponseInterface::HTTP_NO_CONTENT;
                $data['data'] = '';
            }
        } catch (\Exception $e) {
            $data['message'] = $e;
            $data['response'] = ResponseInterface::HTTP_CONFLICT;
            $data['data'] = '';
        }
        // Change array to Json
        echo json_encode($data);
    }

    // Método para obtener los datos del modelo
    public function getDataModel()
    {
        $data = [
            
            'idRoles' => $this->request->getVar('idRoles'), // Cambiado 
            'Descripcion' => $this->request->getVar('Descripcion'),
            'create_at' => date("Y-m-d H:i:s"),
            'update_at' => date("Y-m-d H:i:s"),
        ];
        return $data;
    }
}
