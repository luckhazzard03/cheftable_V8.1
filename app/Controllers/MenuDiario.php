<?php
// Is file namespace
namespace App\Controllers;

use App\Models\MenuDiarioModel;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\ResponseInterface;

class MenuDiario extends Controller
{
    private $primaryKey;
    private $menuDiarioModel;
    private $data;
    private $model;

    public function __construct()
    {
        $this->primaryKey = "idDiario";
        $this->menuDiarioModel = new MenuDiarioModel();
        $this->data = [];
        $this->model = "menudiario";
    }

    // This method is the index, protected by role-based access control
    public function index()
    {
        // Verifying if the session is active
        $session = session();
        if (!$session->has('user_id')) {
            log_message('error', 'Usuario no autenticado.');
            return redirect()->to('/login');
        }

        // Get user role from session
        $userRole = $session->get('role');
        log_message('debug', 'Rol del usuario desde la sesión: ' . json_encode($userRole));

        // Check if the role is allowed (Admin, Chef, or Mesero)
        if (!in_array($userRole, ['Admin', 'Chef', 'Mesero'])) {
            log_message('error', 'Acceso denegado: rol no autorizado. Rol encontrado: ' . json_encode($userRole));
            return redirect()->to('/login');
        }

        // If valid session and role, load the view
        $this->data['title'] = "MENUDIARIO";
        $this->data[$this->model] = $this->menuDiarioModel->orderBy($this->primaryKey, 'ASC')->findAll();
		// Mapeo de menús
		$menus = [
			1 => 'Corriente',
			2 => 'Ejecutivo',
			3 => 'Especial'
		];
	
		// Reemplazar Menu_id_fk con el nombre del menú
		foreach ($this->data[$this->model] as &$obj) {
			$obj['Menu'] = isset($menus[$obj['Menu_id_fk']]) ? $menus[$obj['Menu_id_fk']] : 'Desconocido';
		}
        return view('menudiario/menudiario_view', $this->data);
    }

    // Method for creating MenuDiario, only accessible to authorized roles
    public function create()
    {
        // Verifying if the session is active
        $session = session();
        $userRole = $session->get('role');
        
        // Check if user role is Admin, Chef, or Mesero
        if (!in_array($userRole, ['Admin', 'Chef', 'Mesero'])) {
            return $this->response->setJSON(['message' => 'Acceso denegado', 'response' => ResponseInterface::HTTP_FORBIDDEN]);
        }

        if ($this->request->isAJAX()) {
            $dataModel = $this->getDataModel();
            if ($this->menuDiarioModel->insert($dataModel)) {
                $data['message'] = 'success';
                $data['response'] = ResponseInterface::HTTP_OK;
                $data['data'] = $dataModel;
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

        // Return data in JSON format
        return $this->response->setJSON($data);
    }

    public function singleMenudiario($id = null)
	{
		//Validate is ajax 
		if ($this->request->isAJAX()) {
			//Select user status model	

			if ($data[$this->model] = $this->menuDiarioModel->where($this->primaryKey, $id)->first()) {
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
		//Change array to Json 
		echo json_encode($data);
	}
	//This method consists of update status, obatains id the data from the POST method, return Json 
	public function update()
	{
		//validate is ajax
		if ($this->request->isAJAX()) {
			$today = date("Y-m-d  H:i:s");
			$id = $this->request->getVar($this->primaryKey);
			$dataModel = [
				'Dia' => $this->request->getVar('Dia'),
				'Descripcion' => $this->request->getVar('Descripcion'),
				'Menu_id_fk' => $this->request->getVar('Menu_id_fk'),
				'create_at' => $this->request->getVar('create_at'),
				'update_at' => $this->request->getVar('update_at'),
				
				

			];
			//Update Data Model
			if ($this->menuDiarioModel->update($id, $dataModel)) {
				$data['message'] = 'success';
				$data['response'] = ResponseInterface::HTTP_OK;
				$data['data'] = $dataModel;
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
		// Change array to Json
		echo json_encode($dataModel);
	}
	//this method consist of delete status, obtains id the data from the GET method, return Json
	public function delete($id = null)
	{
		try {
			//delete data model
			if ($this->menuDiarioModel->where($this->primaryKey, $id)->delete($id)) {
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
			$data['message'] = $e;
			$data['response'] = ResponseInterface::HTTP_CONFLICT;
			$data['data'] = '';
		}
		// Change array to Json
		echo json_encode($data);
	}
    // Method for creating data model
    public function getDataModel()
    {
        $data = [
            'idDiario' => $this->request->getVar('idDiario'),
            'Dia' => $this->request->getVar('Dia'),
            'Descripcion' => $this->request->getVar('Descripcion'),
            'Menu_id_fk' => $this->request->getVar('Menu_id_fk'),
            'create_at' => $this->request->getVar('create_at'),
            'update_at' => $this->request->getVar('update_at'),
        ];
        return $data;
    }
}

