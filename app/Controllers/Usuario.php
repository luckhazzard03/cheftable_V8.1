<?php

namespace App\Controllers;

use App\Models\UsuarioModel;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\ResponseInterface;

class Usuario extends Controller
{
    private $primaryKey;
    private $usuarioModel;
    private $data;
    private $model;

    public function __construct()
    {
        $this->primaryKey = "idUsuario";
        $this->usuarioModel = new UsuarioModel();
        $this->data = [];
        $this->model = "usuario";
    }

    // Método para listar usuarios
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

        // Verificar si el rol del usuario es 'Admin'
        if ($userRole !== 'Admin') {
            log_message('error', 'Acceso denegado: el usuario no tiene el rol adecuado. Rol encontrado: ' . json_encode($userRole));
            return redirect()->to('/login');
        }

        // Si el rol es adecuado, cargar la vista de usuarios
        $this->data['title'] = "USUARIOS";
        $this->data[$this->model] = $this->usuarioModel->orderBy($this->primaryKey, 'ASC')->findAll();
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
            $obj['Rol'] = isset($roles[$obj['idRoles_fk']]) ? $roles[$obj['idRoles_fk']] : 'Desconocido';
        }
        return view('usuario/usuario_view', $this->data);
    }

    // Método para crear un nuevo usuario
    public function create()
    {
        if ($this->request->isAJAX()) {
            $dataModel = $this->getDataModel();
            // Verificar si se debe actualizar la contraseña
            if (!empty($dataModel['Password'])) {
                // Encriptar la nueva contraseña y almacenar el hash completo
                $hashedPassword = password_hash($dataModel['Password'], PASSWORD_DEFAULT);
                $dataModel['Password'] = $hashedPassword; // Almacena el hash completo
            } else {
                // Si la contraseña no se proporciona, mantener la existente
                unset($dataModel['Password']); // Esto asegura que no se sobrescriba la contraseña existente
            }
            // Query Insert CodeIgniter
            if ($this->usuarioModel->insert($dataModel)) {
                $data['message'] = 'success';
                $data['response'] = ResponseInterface::HTTP_OK;
                $data['data'] = $dataModel;
                $data['csrf'] = csrf_hash();
            } else {
                $data['message'] = 'Error creating user';
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

    // Método para obtener un solo usuario
    public function singleUsuario($id = null)
    {
        if ($this->request->isAJAX()) {
            if ($data[$this->model] = $this->usuarioModel->where($this->primaryKey, $id)->first()) {
                $data['message'] = 'success';
                $data['response'] = ResponseInterface::HTTP_OK;
                $data['csrf'] = csrf_hash();
            } else {
                $data['message'] = 'User not found';
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

    // Método para actualizar un usuario
    public function update()
    {
        if ($this->request->isAJAX()) {
            $today = date("Y-m-d H:i:s");
            $id = $this->request->getVar($this->primaryKey);
            $dataModel = $this->getDataModel();

            // Verificar si se debe actualizar la contraseña
            if (!empty($dataModel['Password'])) {
                // Encriptar la nueva contraseña y almacenar el hash completo
                $hashedPassword = password_hash($dataModel['Password'], PASSWORD_DEFAULT);
                $dataModel['Password'] = $hashedPassword; // Almacena el hash completo
            } else {
                // Si la contraseña no se proporciona, mantener la existente
                unset($dataModel['Password']); // Esto asegura que no se sobrescriba la contraseña existente
            }

            $dataModel['update_at'] = $today;

            if ($this->usuarioModel->update($id, $dataModel)) {
                $data['message'] = 'success';
                $data['response'] = ResponseInterface::HTTP_OK;
                $data['data'] = $dataModel;
                $data['csrf'] = csrf_hash();
            } else {
                $data['message'] = 'Error updating user';
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

    // Método para eliminar un usuario
    public function delete($id = null)
    {
        try {
            if ($this->usuarioModel->where($this->primaryKey, $id)->delete($id)) {
                $data['message'] = 'success';
                $data['response'] = ResponseInterface::HTTP_OK;
                $data['data'] = "OK";
                $data['csrf'] = csrf_hash();
            } else {
                $data['message'] = 'Error deleting user';
                $data['response'] = ResponseInterface::HTTP_NO_CONTENT;
                $data['data'] = '';
            }
        } catch (\Exception $e) {
            $data['message'] = 'Exception: ' . $e->getMessage();
            $data['response'] = ResponseInterface::HTTP_CONFLICT;
            $data['data'] = '';
        }
        // Change array to Json
        echo json_encode($data);
    }

    // Método para obtener los datos del modelo
    private function getDataModel()
    {
        $data = [
            'idUsuario' => $this->request->getVar('idUsuario'),
            'Nombre' => $this->request->getVar('Nombre'),
            'Password' => $this->request->getVar('Password'),
            'Email' => $this->request->getVar('Email'),
            'Telefono' => $this->request->getVar('Telefono'),
            'idRoles_fk' => $this->request->getVar('idRoles_fk'),
            'create_at' => $this->request->getVar('create_at'),
            'update_at' => $this->request->getVar('update_at'),
        ];
        return $data;
    }
}
