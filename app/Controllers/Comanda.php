<?php

namespace App\Controllers;

use App\Models\ComandaModel;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\ResponseInterface;

class Comanda extends Controller
{
    private $primaryKey;
    private $comandaModel;
    private $data;
    private $model;

    public function __construct()
    {
        $this->primaryKey = "Comanda_id";
        $this->comandaModel = new ComandaModel();
        $this->data = [];
        $this->model = "comanda";
    }

    // Proteger el acceso a Comanda para Admin, Chef, y Mesero
    public function index()
    {
        $session = session();
        if (!$session->has('user_id')) {
            log_message('error', 'Usuario no autenticado.');
            return redirect()->to('/login');
        }

        $userRole = $session->get('role');
        log_message('debug', 'Rol del usuario desde la sesión: ' . json_encode($userRole));

        if (!in_array($userRole, ['Admin', 'Chef', 'Mesero'])) {
            log_message('error', 'Acceso denegado: el usuario no tiene rol adecuado. Rol encontrado: ' . json_encode($userRole));
            return redirect()->to('/login');
        }

        $this->data['title'] = "COMANDA";
        $this->data[$this->model] = $this->comandaModel->orderBy($this->primaryKey, 'ASC')->findAll();
        $roles = [
            3 => 'Mesero',
            4 => 'Mesero2',
            5 => 'Mesero3',
            6 => 'Mesero4',
            7 => 'Mesero5',
        ];

        foreach ($this->data[$this->model] as &$obj) {
            $obj['Rol'] = isset($roles[$obj['idUsuario_fk']]) ? $roles[$obj['idUsuario_fk']] : 'Desconocido';
        }
        return view('comanda/comanda_view', $this->data);
    }

    // Método de creación, solo para Admin, Chef y Mesero
    public function create() 
    {
        if ($this->request->isAJAX()) {
            $dataModel = $this->getDataModel();

            $totalPlatos = (int)$dataModel['Total_platos'];
            $precioPorPlato = (float)$dataModel['Precio_Total'];

            $adicionales = $this->request->getVar('Adicionales') ?: 0;
            $precioAdicionalTotal = (float)$adicionales;

            $dataModel['Precio_Total'] = ($totalPlatos * $precioPorPlato) + $precioAdicionalTotal;
            $dataModel['Adicionales'] = $precioAdicionalTotal;

            if ($this->comandaModel->insert($dataModel)) {
                return $this->response->setJSON(['message' => 'success']);
            } else {
                return $this->response->setJSON(['message' => 'Error al crear la comanda']);
            }
        }

        return $this->response->setJSON(['message' => 'Error Ajax']);
    }
    

    public function singleComanda($id = null)
    {
        if ($this->request->isAJAX()) {
            if ($data[$this->model] = $this->comandaModel->where($this->primaryKey, $id)->first()) {
                $data['message'] = 'success';
                $data['response'] = ResponseInterface::HTTP_OK;
                $data['csrf'] = csrf_hash();
            } else {
                $data['message'] = 'Error create user';
                $data['response'] = ResponseInterface::HTTP_NO_CONTENT;
                $data['data'] = '';
            }
        } else {
            $data['message'] = 'Error Ajax';
            $data['response'] = ResponseInterface::HTTP_CONFLICT;
            $data['data'] = '';
        }
        echo json_encode($data);
    }

    public function update() {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar($this->primaryKey);
            
            // Obtener los datos del modelo
            $totalPlatos = (int)$this->request->getVar('Total_platos');
            $precioPorPlato = (float)$this->request->getVar('Precio_Total');
            
            // Obtener los adicionales
            $adicionales = $this->request->getVar('Adicionales') ?: 0;  // Valor predeterminado 0 si no se ingresan adicionales
            $precioAdicionalTotal = (float)$adicionales;  // Convertir a float
            
            // Calcular el nuevo precio total
            $nuevoPrecioTotal = ($totalPlatos * $precioPorPlato) + $precioAdicionalTotal;
            
            // Datos para actualizar
            $dataModel = [
                'Fecha' => $this->request->getVar('Fecha'),
                'Hora' => $this->request->getVar('Hora'),
                'Total_platos' => (int)$totalPlatos,
                'Precio_Total' => (float)$nuevoPrecioTotal,
                'Tipo_Menu' => $this->request->getVar('Tipo_Menu'),
                'Adicionales' => (float)$precioAdicionalTotal,
                'idUsuario_fk' => $this->request->getVar('idUsuario_fk'),
                'idMesa_fk' => (int)$this->request->getVar('idMesa_fk'),
                'update_at' => date("Ymd H:i:s"),
            ];
            
            if ($this->comandaModel->update($id, $dataModel)) {
                $data['message'] = 'success';
                $data['response'] = ResponseInterface::HTTP_OK;
                $data['data'] = $dataModel;
                $data['csrf'] = csrf_hash();
            } else {
                $data['message'] = 'Error al actualizar la comanda';
                $data['response'] = ResponseInterface::HTTP_NO_CONTENT;
                $data['data'] = '';
            }
        } else {
            $data['message'] = 'Error Ajax';
            $data['response'] = ResponseInterface::HTTP_CONFLICT;
            $data['data'] = '';
        }
        
        echo json_encode($data);
    }
    

    public function delete($id = null)
    {
        try {
            if ($this->comandaModel->where($this->primaryKey, $id)->delete($id)) {
                $data['message'] = 'success';
                $data['response'] = ResponseInterface::HTTP_OK;
                $data['data'] = "OK";
                $data['csrf'] = csrf_hash();
            } else {
                $data['message'] = 'Error create user';
                $data['response'] = ResponseInterface::HTTP_NO_CONTENT;
                $data['data'] = '';
            }
        } catch (\Exception $e) {
            $data['message'] = $e->getMessage();
            $data['response'] = ResponseInterface::HTTP_CONFLICT;
            $data['data'] = '';
        }
        echo json_encode($data);
    }

    public function getDataModel()
    {
        return [
            'Comanda_id' => $this->request->getVar('Comanda_id'),
            'Fecha' => $this->request->getVar('Fecha'),
            'Hora' => $this->request->getVar('Hora'),
            'Total_platos' => $this->request->getVar('Total_platos'),
            'Precio_Total' => $this->request->getVar('Precio_Total'),
            'Tipo_Menu' => $this->request->getVar('Tipo_Menu'),
            'Adicionales' => $this->request->getVar('Adicionales'),
            'idUsuario_fk' => $this->request->getVar('idUsuario_fk'),
            'idMesa_fk' => $this->request->getVar('idMesa_fk'),
            'create_at' => date("Y-m-d H:i:s"),
            'update_at' => date("Y-m-d H:i:s"),
        ];
    }
}
