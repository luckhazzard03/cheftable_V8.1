<?php

namespace App\Controllers;

use App\Models\CierreModel;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ComandaModel; // Asumiendo que existe este modelo para las comandas

class Cierre extends Controller
{
    private $primaryKey;
    private $cierreModel;
    private $data;
    private $model;

    public function __construct()
    {
        $this->primaryKey = "idCierre";
        $this->cierreModel = new CierreModel();
        $this->data = [];
        $this->model = "cierres";
    }

    /**
     * Método para calcular totales
     */
    public function calcularTotales()
    {
        $comandaModel = new ComandaModel();

        // Obtener todas las comandas agrupadas por fecha
        $comandas = $comandaModel->select('Fecha, SUM(precioTotal) as TotalDia')
            ->groupBy('Fecha')
            ->findAll();

        // Crear un arreglo para almacenar los totales por fecha
        $totalesPorFecha = [];
        foreach ($comandas as $comanda) {
            $totalesPorFecha[$comanda['Fecha']] = [
                'Total_Dia' => $comanda['TotalDia'],
                'Total_Semana' => 0, // Inicializar Total Semana
                'Total_Mes' => 0      // Inicializar Total Mes
            ];
        }

        // Calcular totales por semana y mes
        foreach ($totalesPorFecha as $fecha => &$totales) {
            // Calcular el total semanal
            $semana = date('W', strtotime($fecha));
            foreach ($totalesPorFecha as $fechaComparar => $totalesComparar) {
                if (date('W', strtotime($fechaComparar)) == $semana) {
                    // Sumar el Total Día para cada fecha que pertenece a la misma semana
                    $totales['Total_Semana'] += $totalesComparar['Total_Dia'];
                }
            }

            // Calcular el total mensual
            $mes = date('m', strtotime($fecha));
            foreach ($totalesPorFecha as $fechaComparar => $totalesComparar) {
                if (date('m', strtotime($fechaComparar)) == $mes) {
                    // Sumar el Total Día para cada fecha que pertenece al mismo mes
                    $totales['Total_Mes'] += $totalesComparar['Total_Dia'];
                }
            }
        }

        // Guardar o actualizar los cierres en la base de datos
        foreach ($totalesPorFecha as $fecha => $totales) {
            if (!$this->cierreModel->where('Fecha', $fecha)->first()) {
                // Si no existe, inserta un nuevo registro
                $dataCierre = [
                    'Fecha' => $fecha,
                    'Total_Dia' => $totales['Total_Dia'],
                    'Total_Semana' => $totales['Total_Semana'],
                    'Total_Mes' => $totales['Total_Mes'],
                    'idUsuario_fk' => session()->get('user_id'), // Asumiendo que tienes un usuario logueado
                    'create_at' => date("Y-m-d H:i:s"),
                    'update_at' => date("Y-m-d H:i:s"),
                ];
                // Inserta el cierre en la base de datos
                $this->cierreModel->insert($dataCierre);
            } else {
                // Si ya existe, puedes optar por actualizarlo si es necesario.
                // Aquí puedes agregar lógica para actualizar el cierre existente si es necesario.
            }
        }

        return $this->response->setJSON([
            'message' => 'Cálculo exitoso',
            'response' => ResponseInterface::HTTP_OK
        ]);
    }

    public function index()
    {
        // Verificar si la sesión está activa
        $session = session();
        if (!$session->has('user_id')) {
            log_message('error', 'Usuario no autenticado.');
            return redirect()->to('/login');
        }

        // Verificar rol de usuario desde la sesión
        $userRole = $session->get('role');

        // Denegar acceso si el rol no es Admin
        if ($userRole !== 'Admin') {
            log_message('error', 'Acceso denegado: el usuario no tiene rol de admin.');
            return redirect()->to('/login');
        }

        // Cargar la vista si la sesión y el rol son válidos
        $this->data['title'] = "CIERRES";
        $this->data[$this->model] = $this->cierreModel->orderBy($this->primaryKey, 'ASC')->findAll();

        // Mapeo de roles
        $roles = [
            1 => 'ADMIN'
        ];

        // Reemplazar idUsuario_fk con el nombre del rol
        foreach ($this->data[$this->model] as &$obj) {
            $obj['Rol'] = isset($roles[$obj['idUsuario_fk']]) ? $roles[$obj['idUsuario_fk']] : 'Desconocido';
        }

        return view('cierre/cierre_view', $this->data);
    }

    public function create()
    {
        if ($this->request->isAJAX()) {
            // Obtener los datos del formulario, incluidos los valores manuales de Total_Semana y Total_Mes
            $dataModel = $this->getDataModel();

            // Insertar los datos directamente en la base de datos
            if ($this->cierreModel->insert($dataModel)) {
                $data['message'] = 'success';
                $data['response'] = ResponseInterface::HTTP_OK;
                $data['data'] = $dataModel;
                $data['csrf'] = csrf_hash();
            } else {
                $data['message'] = 'Error al crear el cierre';
                $data['response'] = ResponseInterface::HTTP_NO_CONTENT;
                $data['data'] = '';
            }
        } else {
            $data['message'] = 'Error Ajax';
            $data['response'] = ResponseInterface::HTTP_CONFLICT;
            $data['data'] = '';
        }
        return $this->response->setJSON($data);
    }


    public function singleCierre($id = null)
    {
        if ($this->request->isAJAX()) {
            if ($data[$this->model] = $this->cierreModel->where($this->primaryKey, $id)->first()) {
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

    public function update()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar($this->primaryKey);

            // Recoger los valores de los campos, incluidos los totales manuales
            $dataModel = [
                'Fecha' => $this->request->getVar('Fecha'),
                'Total_Dia' => $this->request->getVar('Total_Dia'),
                'Total_Semana' => $this->request->getVar('Total_Semana'),  // Valor actualizado
                'Total_Mes' => $this->request->getVar('Total_Mes'),  // Valor actualizado
                'idUsuario_fk' => session()->get('user_id'),
                'update_at' => date("Y-m-d H:i:s"),
            ];

            if ($this->cierreModel->update($id, $dataModel)) {
                $data['message'] = 'success';
                $data['response'] = ResponseInterface::HTTP_OK;
                $data['data'] = $dataModel;
                $data['csrf'] = csrf_hash();
            } else {
                $data['message'] = 'Error al actualizar el cierre';
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
            if ($this->cierreModel->where($this->primaryKey, $id)->delete($id)) {
                return json_encode(['message' => 'success', 'response' => ResponseInterface::HTTP_OK]);
            } else {
                return json_encode(['message' => 'Error al eliminar el cierre', 'response' => ResponseInterface::HTTP_NO_CONTENT]);
            }
        } catch (\Exception $e) {
            return json_encode(['message' => 'Error: ' . $e, 'response' => ResponseInterface::HTTP_CONFLICT]);
        }
    }

    public function getDataModel()
    {
        return [
            'idCierre' => null,
            'Fecha' => $this->request->getVar('Fecha'),  // Fecha será tomada del formulario
            'Total_Dia' => $this->request->getVar('Total_Dia'),  // Total_Dia tomado del formulario
            'Total_Semana' => $this->request->getVar('Total_Semana'),  // Total_Semana tomado del formulario
            'Total_Mes' => $this->request->getVar('Total_Mes'),  // Total_Mes tomado del formulario
            'idUsuario_fk' => session()->get('user_id'),
            'create_at' => date("Y-m-d H:i:s"),
            'update_at' => date("Y-m-d H:i:s"),
        ];
    }
}
