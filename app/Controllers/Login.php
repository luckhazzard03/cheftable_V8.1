<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UsuarioModel;

class Login extends BaseController
{
    public function index()
    {
        // Muestra la vista de login
        return view('login');
    }

    public function authenticate()
    {
        // Instancia del modelo UsuarioModel
        $userModel = new UsuarioModel();

        // Obtener el valor del parámetro 'email' y 'password' enviados en la solicitud HTTP
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        // Verificar si 'email' y 'password' están presentes en la solicitud
        if (!$email || !$password) {
            log_message('error', 'Email o contraseña no proporcionados. Email: ' . $email);
            return redirect()->back()->with('error', 'Email y contraseña son requeridos.');
        }

        // Buscar el usuario en la base de datos con su rol
        $user = $userModel->getUserWithRole($email); 

        log_message('debug', 'Usuario con rol: ' . json_encode($user));  // Verificar que el rol está presente

        if (!$user) {
            log_message('error', 'Usuario no encontrado para el email: ' . $email);
            return redirect()->back()->with('error', 'Email no encontrado.');
        }

        // Verificar si la contraseña es correcta usando password_verify()
        if (!password_verify($password, $user['Password'])) {
            log_message('error', 'Contraseña incorrecta para el email: ' . $email);
            return redirect()->back()->with('error', 'Contraseña incorrecta.');
        }

        // Si todo es correcto, guarda la sesión con la información relevante, incluyendo el rol
        session()->set([
            'user_id' => $user['idUsuario'],  // Guarda 'idUsuario'
            'email' => $user['Email'],
            'role' => $user['Rol'], // Asigna el nombre del rol
        ]);

        // Imprimir en el log el rol que se guarda en la sesión
        log_message('debug', 'Rol asignado al usuario: ' . $user['Rol']);  // Esto imprimirá el rol en el log
        log_message('debug', 'Rol guardado en sesión: ' . session()->get('role'));  // Verifica si el rol está guardado correctamente

        log_message('debug', 'Sesión iniciada para el usuario: ' . $user['Email']);
        
        // Redirigir al dashboard o menú después del login
        return redirect()->to(base_url('menu'));  // O donde desees redirigir
    }

    public function logout()
    {
        // Eliminar todos los datos de sesión
        session()->remove(['user_id', 'email', 'role']);
    
        log_message('debug', 'Sesión cerrada correctamente');
        
        // Redirigir a la vista de login
        return redirect()->to(base_url('login'));
    }
}
