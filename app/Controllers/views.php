<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Views extends Controller
{
    public function pagina()
    {
        return view('pagina'); // Asegúrate de que 'pagina.php' esté en 'app/Views/'
    }
}
