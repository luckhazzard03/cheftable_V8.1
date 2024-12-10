<?php
namespace App\Controllers;

use App\Models\ComandaMenuModel;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\ResponseInterface;

class ComandaMenu extends Controller
{
    private $primaryKey;
    private $ComandaMenuModel;
    private $data;
    private $model;

    public function __construct()
    {
        $this->primaryKey = "Comanda_menu_id";
        $this->ComandaMenuModel = new ComandaMenuModel();
        $this->data = [];
        $this->model = "comanda_menu";
    }

    // Método para verificar el acceso
    private function checkAccess()
    {
        $session = session();
        if (!$session->has('user_id')) {
            log_message('error', 'Usuario no autenticado.');
            return redirect()->to('/login');
        }

        $userRole = $session->get('role');
        if (!in_array($userRole, ['Admin', 'Chef', 'Mesero'])) {
            log_message('error', 'Acceso denegado: el usuario no tiene un rol permitido. Rol encontrado: ' . json_encode($userRole));
            return redirect()->to('/login');
        }

        return true;
    }

    public function index()
    {
        // Verificar acceso
        if ($this->checkAccess() !== true) {
            return redirect()->to('/login');
        }

        $this->data['title'] = "COMANDAS MENU";
        $this->data[$this->model] = $this->ComandaMenuModel->orderBy($this->primaryKey, 'ASC')->findAll();
        return view('comandaMenu/comandaMenu_view', $this->data);
    }

    public function create()
    {
        if ($this->checkAccess() !== true) {
            return redirect()->to('/login');
        }

        if ($this->request->isAJAX()) {
            $dataModel = $this->getDataModel();
            if ($this->ComandaMenuModel->insert($dataModel)) {
                $data['message'] = 'success';
                $data['response'] = ResponseInterface::HTTP_OK;
                $data['data'] = $dataModel;
                $data['csrf'] = csrf_hash();
            } else {
                $data['message'] = 'Error creando la comanda';
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

    public function singleComandaMenu($id = null)
    {
        if ($this->checkAccess() !== true) {
            return redirect()->to('/login');
        }

        if ($this->request->isAJAX()) {
            if ($data[$this->model] = $this->ComandaMenuModel->where($this->primaryKey, $id)->first()) {
                $data['message'] = 'success';
                $data['response'] = ResponseInterface::HTTP_OK;
                $data['csrf'] = csrf_hash();
            } else {
                $data['message'] = 'Error al obtener la comanda';
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

    public function update()
    {
        if ($this->checkAccess() !== true) {
            return redirect()->to('/login');
        }

        if ($this->request->isAJAX()) {
            $id = $this->request->getVar($this->primaryKey);
            $dataModel = [
                'Cantidad_Menu' => $this->request->getVar('Cantidad_Menu'),
                'Precio' => $this->request->getVar('Precio'),
                'Descripcion' => $this->request->getVar('Descripcion'),
                'update_at' => date("Y-m-d H:i:s"),
            ];

            if ($this->ComandaMenuModel->update($id, $dataModel)) {
                $data['message'] = 'success';
                $data['response'] = ResponseInterface::HTTP_OK;
                $data['data'] = $dataModel;
                $data['csrf'] = csrf_hash();
            } else {
                $data['message'] = 'Error actualizando la comanda';
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
        if ($this->checkAccess() !== true) {
            return redirect()->to('/login');
        }

        try {
            if ($this->ComandaMenuModel->where($this->primaryKey, $id)->delete($id)) {
                $data['message'] = 'success';
                $data['response'] = ResponseInterface::HTTP_OK;
                $data['data'] = "OK";
                $data['csrf'] = csrf_hash();
            } else {
                $data['message'] = 'Error eliminando la comanda';
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
            'Comanda_menu_id' => $this->request->getVar('Comanda_menu_id'),
            'Cantidad_Menu' => $this->request->getVar('Cantidad_Menu'),
            'Precio' => $this->request->getVar('Precio'),
            'Descripcion' => $this->request->getVar('Descripcion'),
            'Comanda_fk' => $this->request->getVar('Comanda_fk'),
            'Menu_fk' => $this->request->getVar('Menu_fk'),
            'create_at' => date("Y-m-d H:i:s"),
            'update_at' => date("Y-m-d H:i:s"),
        ];
    }
}
?>
