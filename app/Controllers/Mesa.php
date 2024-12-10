<?php
// Is file namespace
namespace App\Controllers;
use App\Models\MesaModel;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Session\Session; // Asegúrate de cargar la sesión

class Mesa extends Controller
{
    private $primaryKey;
    private $mesaModel;
    private $data;
    private $model;
    private $session;

    // Constructor
    public function __construct()
    {
        $this->primaryKey = "idMesa";
        $this->mesaModel = new MesaModel();
        $this->data = [];
        $this->model = "mesas";
        $this->session = \Config\Services::session();  // Inicia la sesión
    }

    // Verificar si el usuario tiene el rol adecuado
    private function checkRole($requiredRoles)
    {
        $userRole = $this->session->get('role');  // Obtiene el rol del usuario desde la sesión
        
        // Verificar que $requiredRoles es un array
        if (!is_array($requiredRoles)) {
            throw new \InvalidArgumentException('El parámetro $requiredRoles debe ser un array.');
        }
        
        // Verifica si el rol del usuario está en el array de roles permitidos
        if (!in_array($userRole, $requiredRoles)) {
            return false;
        }
        return true;
    }

    // Index: Mostrar mesas
    public function index()
    {
        // Verificar que el usuario sea Admin, Chef o Mesero
        if (!$this->checkRole(['Admin', 'Chef', 'Mesero'])) {
            return redirect()->to('/login'); // Redirigir si no tiene permiso
        }
        $this->data['title'] = "MESAS";
        $this->data[$this->model] = $this->mesaModel->orderBy($this->primaryKey, 'ASC')->findAll();
        return view('mesa/mesa_view', $this->data);
    }

    // Crear mesa
    public function create()
    {
        // Verificar si el usuario tiene uno de los roles permitidos ('Admin', 'Chef', 'Mesero')
        if (!$this->checkRole(['Admin', 'Chef', 'Mesero'])) {
            return redirect()->to('/login'); // Redirigir si no tiene permiso
        }
    
        if ($this->request->isAJAX()) {
            $dataModel = $this->getDataModel();
            // Query Insert Codeigniter
            if ($this->mesaModel->insert($dataModel)) {
                $data['message'] = 'success';
                $data['response'] = ResponseInterface::HTTP_OK;
                $data['data'] = $dataModel;
                $data['csrf'] = csrf_hash();
            } else {
                $data['message'] = 'Error creating mesa';
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

   // Este método consiste en obtener el estado de una sola mesa, obtiene el id de los datos del método GET y retorna JSON
	public function singleMesa($id = null)
	{
		// Verificar si es una solicitud Ajax 
		if ($this->request->isAJAX()) {
			// Selecciona el modelo de estado de la mesa
			if ($data[$this->model] = $this->mesaModel->where($this->primaryKey, $id)->first()) {
				$data['message'] = 'success';
				$data['response'] = ResponseInterface::HTTP_OK;
				$data['csrf'] = csrf_hash();
			} else {
				$data['message'] = 'Error al obtener la mesa';
				$data['response'] = ResponseInterface::HTTP_NO_CONTENT;
				$data['data'] = '';
			}
		} else {
			$data['message'] = 'Error Ajax';
			$data['response'] = ResponseInterface::HTTP_CONFLICT;
			$data['data'] = '';
		}
		// Cambia el array a JSON 
		echo json_encode($data);
	}

    // Este método consiste en actualizar el estado de una mesa, obtiene el id de los datos del método POST y retorna JSON
	public function update()
	{
		// Verificar si es una solicitud Ajax
		if ($this->request->isAJAX()) {
			$today = date("Y-m-d  H:i:s");
			$id = $this->request->getVar($this->primaryKey);
			$dataModel = [
				'No_Orden' => $this->request->getVar('No_Orden'),
				'Estado' => $this->request->getVar('Estado'),			
				'Capacidad' => $this->request->getVar('Capacidad'),			
				'create_at' => $this->request->getVar('create_at'),			
				'update_at' => $this->request->getVar('update_at'),			
			];
			// Actualiza el modelo de datos
			if ($this->mesaModel->update($id, $dataModel)) {
				$data['message'] = 'success';
				$data['response'] = ResponseInterface::HTTP_OK;
				$data['data'] = $dataModel;
				$data['csrf'] = csrf_hash();
			} else {
				$data['message'] = 'Error al actualizar la mesa';
				$data['response'] = ResponseInterface::HTTP_NO_CONTENT;
				$data['data'] = '';
			}
		} else {
			$data['message'] = 'Error Ajax';
			$data['response'] = ResponseInterface::HTTP_CONFLICT;
			$data['data'] = '';
		}
		// Cambia el array a JSON
		echo json_encode($dataModel);
	}

	// Este método consiste en eliminar una mesa, obtiene el id de los datos del método GET y retorna JSON
	public function delete($id = null)
	{
		try {
			// Elimina el modelo de datos
			if ($this->mesaModel->where($this->primaryKey, $id)->delete($id)) {
				$data['message'] = 'success';
				$data['response'] = ResponseInterface::HTTP_OK;
				$data['data'] = "OK";
				$data['csrf'] = csrf_hash();
			} else {
				$data['message'] = 'Error al eliminar la mesa';
				$data['response'] = ResponseInterface::HTTP_NO_CONTENT;
				$data['data'] = '';
			}
		} catch (\Exception $e) {
			$data['message'] = $e;
			$data['response'] = ResponseInterface::HTTP_CONFLICT;
			$data['data'] = '';
		}
		// Cambia el array a JSON
		echo json_encode($data);
	}

    // Este método recibe los datos del formulario y los asigna al modelo
    public function getDataModel()
    {
        $data = [
            'idMesa' => $this->request->getVar('idMesa'),
            'No_Orden' => $this->request->getVar('No_Orden'),
            'Estado' => $this->request->getVar('Estado'),
            'Capacidad' => $this->request->getVar('Capacidad'),
            'create_at' => $this->request->getVar('create_at'),
            'update_at' => $this->request->getVar('update_at'),
        ];
        return $data;
    }
}
