<?php

namespace App\Models;

use CodeIgniter\Model;
use Exception;
class LoginModel extends Model
{
    protected $table            = 'usuarios';
    protected $primaryKey       = 'idUsuario';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['Nombre','Password','Email','Telefono','idRoles_fk','create_at', 'update_at'];

    protected bool $allowEmptyInserts = false;

    protected $updatedField  = 'update_at';
    protected $deletedField  = 'create_at';

}
